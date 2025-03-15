<?php
/**
 * Plugin Name: Block Mail.ru
 * Description: Block user registrations with mail.ru accounts
 * Version: 0.1.0
 * Author: Sam Tyurenkov
 * Text Domain: block-mail-ru
 * Domain Path: /languages
 */


if (! defined('ABSPATH')) {
	exit; // Exit if accessed directly.
}

class BlockMailRu
{
	public array $mailru_domains = [
		'bk.ru',
		'mail.ru',
		'inbox.ru',
		'internet.ru',
		'list.ru'
	];

	public function __construct()
	{
		add_filter( 'registration_errors', [$this, 'block_mail_ru_registration'], 10, 3 );
	}

	function block_mail_ru_registration( $errors, $sanitized_user_login, $user_email ) {
		// Extract the domain from the email address
		$email_domain = strtolower( substr( strrchr( $user_email, "@" ), 1 ) );
		// Check if the domain is mail.ru
		if ( in_array($email_domain, $this->mailru_domains) ) {
			// Add a custom error message
			$errors->add( 'mail_ru_blocked', __( 'Registration is not allowed with mail.ru email addresses. Please use a different email.', 'block-mail-ru' ) );
		}
	
		return $errors;
	}
	
}

new BlockMailRu();