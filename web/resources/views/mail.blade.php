<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $details['subject'] }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
        .header {
            text-align: center;
            padding-bottom: 20px;
        }
        .measurement-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .measurement-table th, .measurement-table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        .measurement-table th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>{{ $details['subject'] }}</h2>
    </div>

    <p>Dear Customer,</p>

    <p>Here are the details of your recent configuration:</p>

    <table class="measurement-table">
        <thead>
        <tr>
            <th>Field</th>
            <th>Value</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>Wall Width</td>
            <td>{{ $details['wall_width'] }} {{ $details['wall_unit'] }}</td>
        </tr>
        <tr>
            <td>Wall Height</td>
            <td>{{ $details['wall_height'] }} {{ $details['wall_unit'] }}</td>
        </tr>
        <tr>
            <td>Dun Width</td>
            <td>{{ $details['dun_width'] }} {{ $details['dun_unit'] }}</td>
        </tr>
        <tr>
            <td>Dun Height</td>
            <td>{{ $details['dun_height'] }} {{ $details['dun_unit'] }}</td>
        </tr>
        <tr>
            <td>Form Type</td>
            <td>{{ $details['form_type'] }}</td>
        </tr>
        <tr>
            <td>Show Measurement</td>
            <td>{{ $details['show_measurement'] ? 'True' : 'False' }}</td>
        </tr>
        <tr>
            <td>Shape</td>
            <td>{{ $details['shape'] }}</td>
        </tr>
        <tr>
            <td>Vertical Density</td>
            <td>{{ $details['vertical_density'] }}</td>
        </tr>
        <tr>
            <td>Horizontal Density</td>
            <td>{{ $details['horizontal_density'] }}</td>
        </tr>
        <tr>
            <td>Builder Link</td>
            <td>
                <a href="https://a8fcb0-2.myshopify.com/pages/builder?preview={{ $details['unique_id'] }}" target="_blank">
                    View Builder
                </a>
            </td>
        </tr>
        </tbody>
    </table>

    <p>If you have any questions, feel free to reach out to us.</p>

    <p>Best regards,<br> The Team</p>
</div>
</body>
</html>
