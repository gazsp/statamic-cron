<?php

$members = MemberService::getMembers()->get();
$first = reset($members);

// Do something...
var_dump($first);
