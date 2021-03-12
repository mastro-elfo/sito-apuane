<?php

function open_db() {
  $mysqli = new mysqli("localhost", "root", "", "apuane");
  /* check connection */
  if ($mysqli->connect_errno) {
      return null;
  }
  return $mysqli;
}
