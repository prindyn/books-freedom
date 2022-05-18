<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TelegramRegisterCommand extends Command
{
    /**
     * The console command signature.
     *
     * @var string
     */
    protected $signature = 'laravel:telegram:register {--remove} {--output}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Register or unregister your bot with Telegram\'s webhook';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $url = 'https://api.telegram.org/bot'
            . config('botman.telegram.token')
            . '/setWebhook';

        $remove = $this->option('remove', null);

        if (!$remove) {
            $webhookUrl = $this->ngrok();
            $url .= '?url=' . ($webhookUrl ?? $this->ask('What is the target url for the telegram bot?'));
            $url .= '/botman';
        } else {
            shell_exec("killall ngrok");
        }

        $this->info('Using ' . $url);

        $this->info('Pinging Telegram...');

        $output = json_decode(file_get_contents($url));

        if ($output->ok == true && $output->result == true) {
            $this->info(
                $remove
                    ? 'Your bot Telegram\'s webhook has been removed!'
                    : 'Your bot is now set up with Telegram\'s webhook!'
            );
        }

        if ($this->option('output')) {
            dump($output);
        }
    }

    protected function ngrok($port = '8000')
    {
        shell_exec("ngrok http $port > /dev/null &");
        sleep(1);
        $ngrok = json_decode(file_get_contents('http://localhost:4040/api/tunnels'), true);
        $env = getenv();

        foreach ($ngrok['tunnels'] as $tunnel) {

            if (strpos($tunnel['public_url'], 'https://') !== false) {
                $env['TG_WEBHOOK_URL'] =  $tunnel['public_url'];
                $this->updateEnv($env);
            }
        }
        return $env['TG_WEBHOOK_URL'];
    }

    protected function updateEnv($data = array())
    {
        if (!count($data)) {
            return;
        }

        $pattern = '/([^\=]*)\=[^\n]*/';

        $envFile = base_path() . '/.env';
        $lines = file($envFile);
        $newLines = [];
        foreach ($lines as $line) {
            preg_match($pattern, $line, $matches);

            if (!count($matches)) {
                $newLines[] = $line;
                continue;
            }

            if (!key_exists(trim($matches[1]), $data)) {
                $newLines[] = $line;
                continue;
            }

            $line = trim($matches[1]) . "={$data[trim($matches[1])]}\n";
            $newLines[] = $line;
        }

        $newContent = implode('', $newLines);
        file_put_contents($envFile, $newContent);
    }
}
