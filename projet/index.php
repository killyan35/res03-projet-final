<?php
require 'autoload.php';
session_start();
$newRouter = new Router();
$newRouter->checkRoute();
