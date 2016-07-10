<?php
namespace FilterAndSummarize;
spl_autoload_register(function ($className) {
    $className = str_replace('FilterAndSummarize\\', '', $className);
    include 'src/' . $className . '.php';
});