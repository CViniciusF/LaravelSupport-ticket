<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Suppor Ticket Information</title>
</head>
<body>
    <p>
        Obrigado {{ ucfirst($user->name) }} por contatar nosso suporte. Um ticket foi aberto para você. Você será avisado quando receber uma resposta. The details of your ticket are shown below:
    </p>

    <p>Title: {{ $ticket->title }}</p>
    <p>Priority: {{ $ticket->priority }}</p>
    <p>Status: {{ $ticket->status }}</p>

    <p>
        You can view the ticket at any time at {{ url('tickets/'. $ticket->ticket_id) }}
    </p>

</body>
</html>