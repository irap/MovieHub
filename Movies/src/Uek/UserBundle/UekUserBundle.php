<?php

// src/Uek/UserBundle/UekUserBundle.php
namespace Uek\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class UekUserBundle extends Bundle
{
	public function getParent()
	{
		return 'FOSUserBundle';
	}
}
