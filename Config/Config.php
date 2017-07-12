<?php

define('HOST', 'localhost');
define('NAME', 'alpha');
define('USER', 'root');
define('PASS', 'root');
/**
 * Configuration for: Cookies
 * Please note: The COOKIE_DOMAIN needs the domain where your app is,
 * in a format like this: .mydomain.com
 * Note the . in front of the domain. No www, no http, no slash here!
 * For local development .127.0.0.1 or .localhost is fine, but when deploying you should
 * change this to your real domain, like '.mydomain.com' ! The leading dot makes the cookie available for
 * sub-domains too.
 * @see http://stackoverflow.com/q/9618217/1114320
 * @see http://www.php.net/manual/en/function.setcookie.php
 *
 * COOKIE_RUNTIME: How long should a cookie be valid ? 1209600 seconds = 2 weeks
 * COOKIE_DOMAIN: The domain where the cookie is valid for, like '.mydomain.com'
 * COOKIE_SECRET_KEY: Put a random value here to make your app more secure. When changed, all cookies are reset.
 */
define("COOKIE_RUNTIME", 1209600);
define("COOKIE_DOMAIN", ".twohills.tv");
define("COOKIE_SECRET_KEY", "1gp@TMPS{+$78sfpMJFe-92s");

/**
 * Configuration for: Hashing strength
 * This is the place where you define the strength of your password hashing/salting
 *
 * To make password encryption very safe and future-proof, the PHP 5.5 hashing/salting functions
 * come with a clever so called COST FACTOR. This number defines the base-2 logarithm of the rounds of hashing,
 * something like 2^12 if your cost factor is 12. By the way, 2^12 would be 4096 rounds of hashing, doubling the
 * round with each increase of the cost factor and therefore doubling the CPU power it needs.
 * Currently, in 2013, the developers of this functions have chosen a cost factor of 10, which fits most standard
 * server setups. When time goes by and server power becomes much more powerful, it might be useful to increase
 * the cost factor, to make the password hashing one step more secure. Have a look here
 * (@see https://github.com/panique/php-login/wiki/Which-hashing-&-salting-algorithm-should-be-used-%3F)
 * in the BLOWFISH benchmark table to get an idea how this factor behaves. For most people this is irrelevant,
 * but after some years this might be very very useful to keep the encryption of your database up to date.
 *
 * Remember: Every time a user registers or tries to log in (!) this calculation will be done.
 * Don't change this if you don't know what you do.
 *
 * To get more information about the best cost factor please have a look here
 * @see http://stackoverflow.com/q/4443476/1114320
 *
 * This constant will be used in the login and the registration class.
 */
define("HASH_COST_FACTOR", "10");

define("EMAIL_ALREADY_EXISTS", "Esse email já existe em nossos Bancos de Dados!");
define("ACCOUNT_NOT_CREATED", "Houve um erro, sua conta não pode ser criada");
define("MESSAGE_VERIFICATION_MAIL_ERROR", "Houve um erro ao enviar o email de ativação, sua conta não foi criada!");
define("MESSAGE_VERIFICATION_MAIL_SENT", "Sua conta foi criada com sucesso, verifique seu email!");
define("MESSAGE_REGISTRATION_ACTIVATION_SUCCESSFUL", "Conta ativada com sucesso!");
define("MESSAGE_REGISTRATION_ACTIVATION_NOT_SUCCESSFUL", "Conta já ativada ou houve um problema com seu tokem, entre em contato com o administrador");
define("MESSAGE_LOGOUT", "Você foi deslogado com sucesso!");
define("LOGIN_FAIL", "Usuário ou senha incorretos, ou não existem");
define("PASSWORD_WRONG_3_TIMES", "Sua senha esteve errada por tres tentativas consecutivas, um email de recuperação foi enviado para seu email cadastrado");
define('PASSWORD_WRONG', 'Senha incorreta');
define('ACCOUNT_NOT_ACTIVATED', 'Conta não ativada, favor verificar seu email');

//define("ACCOUNT_NOT_CREATED", "Houve um problema, sua conta não foi criada!");
