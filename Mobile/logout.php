<?php
kuume_session();
unset($_SESSION[UID]);
session_destroy();