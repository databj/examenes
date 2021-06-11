<?php

$tema=TemaData::delById($_POST["id"]);

core::redir("./?view=Tema/View_Tema");

