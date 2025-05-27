<?php
function getPDO() {
    return new PDO('mysql:host=localhost;dbname=Aurora;charset=utf8mb4', 'root', '');
}