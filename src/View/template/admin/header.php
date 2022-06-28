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
  <?= $this->getLink(ADMIN_CSS); ?>
</head>
<body>
<div class="wrapper">
    <header class="header">
        <div class="container">
           <div class="header__row">
               <div class="header__col">
                   <div class="header__title">
                       Hello, admin!
                   </div>
               </div>
               <div class="header__col">
                   <nav class="header__nav">
                       <ul>
                           <li>
                               <a href="/admin">
                                   Main
                               </a>
                           </li>
                           <li>
                               <a href="/admin/log">
                                   Site logs
                               </a>
                           </li>
                           <li>
                               <a href="/admin/logout">
                                   Log out
                               </a>
                           </li>
                       </ul>
                   </nav>
               </div>
           </div>
        </div>
    </header>
    <main>



