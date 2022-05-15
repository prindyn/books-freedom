📚<b> {{ $book->title }} - {{ implode(', ', $book->authors) }} </b>📚

📋<b> Кількість сторінок:</b><i> {{ $book->pageCount }} </i>📋

<i>{{ Str::limit($book->description, 650) }}</i>

❗️ <i>Дані матеріали розміщено для ознайомлення.</i>