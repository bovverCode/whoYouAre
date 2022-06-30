<?php
/**
 * Admin header template
 */
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
  <title> Who you are </title>
  <?= $this->getFavIcon(); ?>
  <?= $this->getLink(ADMIN_CSS); ?>
</head>
<body>
<div class="wrapper">
    <header class="header">
        <div class="container">
            <div class="header__row">
                <div class="header__col">
                    <div class="logo">
                        <a href="/">
                            LOGO
                        </a>
                    </div>
                </div>
                <div class="header__col">
                    <nav class="header__nav">
                        <ul>
                            <li>
                                <a href="/">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="/who-we-are">
                                    Who we are
                                </a>
                            </li>
                            <li>
                                <a href="/exit">
                                    Exit
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
    <main>



