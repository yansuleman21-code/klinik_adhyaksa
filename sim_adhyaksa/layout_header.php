<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($title) ? $title : 'Klinik Pratama Adhyaksa'; ?></title>
    <link rel="icon" type="image/png" href="/klinikAdhyaksa/images/logo.png">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        .sidebar-active {
            background-color: rgba(255, 255, 255, 0.1);
            border-left: 4px solid #2ecc71;
        }

        /* Custom Green Theme matching Landing Page */
        :root {
            --primary-green: #006039;
        }

        .bg-primary-green {
            background-color: var(--primary-green);
        }

        .text-primary-green {
            color: var(--primary-green);
        }
    </style>
</head>

<body class="bg-gray-100 font-sans">
    <div class="flex h-screen overflow-hidden">