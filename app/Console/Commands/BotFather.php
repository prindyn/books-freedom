<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use SebastianBergmann\Invoker\TimeoutException;

class BotFather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'botfather:msg {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Conversation with telegram BotFather';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();

        $this->botFatherName = 'BotFather';
        $this->tgClientKey = env('TELEGRAM_CLI_KEY', 'tg-server.pub');
        $this->pattern = '
        /
        \{              # { character
            (?:         # non-capturing group
                [^{}]   # anything that is not a { or }
                |       # OR
                (?R)    # recurses the entire pattern
            )*          # previous group zero or more times
        \}              # } character
        /x
        ';
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $message = $this->argument('message');

        return $this->sendMessage($message);
    }

    protected function sendMessage($message)
    {
        $command = env('TELEGRAM_CLI_PATH') . ' -W --json';

        if (!env('TELEGRAM_CLI_PATH')) {
            return dd(
                response()->json(["status" => false, "message" => "Telegram client not found"], 500)
            );
        }

        if (file_exists(storage_path("app/public/{$this->tgClientKey}"))) {
            $command .= " -k {$this->tgClientKey}";
        }

        try {
            $response = $this->execute_shell("$command -e 'msg $this->botFatherName $message'", 5);
            $response = $this->execute_shell("$command -e 'history $this->botFatherName 1'", 5);

            preg_match_all($this->pattern, $response, $matches);

            foreach ($matches[0] as $each) {
                $each = is_string($each) ? json_decode($each, true) : $each;
                if ($each['event'] == 'message') $result = $each;
            }

            if (empty($result)) throw new TimeoutException('Telegram client no response');

            return dd(
                response()->json([$result], 200)
            );
        } catch (TimeoutException $e) {

            return dd(
                response()->json(["status" => false, "message" => $e->getMessage()], 408)
            );
        }
    }

    protected function execute_shell(string $command, int $timeout = 5, $hardKill = true): string
    {
        $handle = proc_open($command, [['pipe', 'r'], ['pipe', 'w'], ['pipe', 'w']], $pipe);

        $startTime = microtime(true);

        /* Read the command output and kill it if the proccess surpassed the timeout */
        $read = '';
        while (!feof($pipe[1])) {
            $read .= fread($pipe[1], 8192);
            if ($startTime + $timeout < microtime(true)) break;
        }

        if (proc_get_status($handle)['running'] || $hardKill) {
            $this->kill(proc_get_status($handle)['pid']);
        }
        proc_close($handle);

        return $read;
    }

    /**
     * The proc_terminate() function doesn't end proccess properly on Windows
     */
    protected function kill(string $pid): string
    {
        return strstr(PHP_OS, 'WIN') ? exec("taskkill /F /T /PID $pid") : exec("kill -9 $pid");
    }
}
