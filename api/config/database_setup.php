<?php

// Include action.php file
require_once 'Db_connect.php';
require_once 'CreateDatabase.php';
require_once 'CreateMenteeTable.php';
require_once 'CreateMentorTable.php';
require_once 'CreateMenteesMentorTable.php';

// Create object of Users class
$database = new CreateDatabase();

$MenteeTable = new CreateMenteeTable();
$MenteeTable->addTestData();
$MenteeTable->closeDbConnection();

$MentorTable = new CreateMentorTable();
$MentorTable->addTestData();
$MentorTable->closeDbConnection();

$MenteesMentorTable = new CreateMenteesMentorTable();
$MenteesMentorTable->addTestData();
$MenteesMentorTable->closeDbConnection();
