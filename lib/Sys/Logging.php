<?php
namespace Sys;

class Logging
{
    public function __construct()
    {
        var_dump("logging");
    }
    
    public function info($msg)
    {
        var_dump("$msg <br>");
    }
}
