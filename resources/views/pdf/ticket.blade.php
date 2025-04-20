<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Ticket PDF</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
        font-family: 'Helvetica', sans-serif;
        margin: 0;
        padding: 40px;
        background: #fff;
        color: #333;
        }

        .ticket-wrapper {
        max-width: 700px;
        margin: auto;
        border: 2px dashed #444;
        padding: 30px;
        border-radius: 12px;
        }

        .ticket-header {
        text-align: center;
        background-color: #111827;
        color: white;
        padding: 20px;
        border-radius: 10px 10px 0 0;
        }

        .ticket-header h1 {
        margin: 0;
        font-size: 28px;
        }

        .info-section {
        padding: 20px 0;
        }

        .label {
        font-size: 11px;
        text-transform: uppercase;
        color: #888;
        }

        .value {
        font-size: 16px;
        font-weight: bold;
        margin-bottom: 12px;
        }

        .ticket-box {
        background-color: #f8f8f8;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 16px;
        border-left: 4px solid #3b82f6;
        }

        .footer {
        font-size: 12px;
        color: #888;
        text-align: center;
        margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="ticket-wrapper">
        <div class="ticket-header">
            <h1> Your Event Ticket</h1>
        </div>

        <div class="info-section">
            <div class="value">Name: {{ $user->name }}</div>
            <div class="value">Email: {{ $user->email }}</div>
            <div class="value">Reference: {{ $registration->receipt_number }}</div>
        </div>

        <div class="ticket-box">
            <div class="label">Event</div>
            <div class="value">{{ $event->title }}</div>

            <div class="label">Preferred Name</div>
            <div class="value">{{ $registration->prefered_name }}</div>
        </div>

        <div class="footer">
            Please present this ticket at the venue entrance. Valid for one-time entry.
        </div>
    </div>
</body>
</html>
