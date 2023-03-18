<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>


@component('mail::message')
# Introduction

The body of your message.

@component('mail::button', ['url' => ''])
Button Text
@endcomponent

<a href="{{ url('http://127.0.0.1:8000/InvoicesDetails') }}/{{$invoice_id}}" class = "btn-primary" >تفاصيل</a>


Thanks,<br>
{{ config('app.name') }}
@endcomponent
