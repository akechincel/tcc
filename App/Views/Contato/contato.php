<!DOCTYPE html>
<html lang="pt-br">

<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SAC - Bhaskara</title>
</head>

<body>
    <header>
        <img src="" alt="bhaskara">
        <a href="/">
            <i href="" class="bi bi-house-fill"></i>
        </a>
    </header>
    <hr>
    <div class="imagemdotheo"></div>

    <main>
        <h1 class="lexend">Contato</h1>
        <hr>
        <p>
            <i class="bi bi-telephone-forward-fill"></i>
            (11) 9999-9999
        </p>
        <p>
            <i class="bi bi-envelope-open-fill"></i>
            bhaskara@sac.edu.com
        </p>
    </main>

</body>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Lexend:wght@100..900&display=swap");

    :root {
        --text: #26210d;
        --text-inv: #f2edd9;
        --background: #f7f0dc;
        --primary: #234c67;
        --secondary: #b1d4f6;
        --accent: #cfa93f;
        --shadow: #201a0851;
    }

    body {
        overflow: hidden;
        background-color: var(--background);
    }

    * {
        color: var(--text);
    }

    .lexend {
        font-family: "Lexend", sans-serif;
        color: var(--text);
    }

    header {
        display: flex;
        justify-content: space-evenly;
        align-items: center;
    }

    main {
        margin: 0 0 0 5rem;
    }

    h1 {
        font-size: 6rem;
        line-height: 5rem;
        margin-bottom: 2rem;
    }


    .imagemdotheo {
        float: right;
        width: 600px;
        height: 600px;
    }

    span {
        color: var(--primary);
        font-weight: bold;
    }

    i {
        color: var(--text);
    }
</style>

</html>