<?php
class ZKernel{

	public static function enable(){
		error_reporting(0);
		register_shutdown_function([__CLASS__, 'shutdownHandler']);
		set_exception_handler([__CLASS__, 'exceptionHandler']);
		set_error_handler([__CLASS__, 'errorHandler']);
	}

	/*
	Shutdown handler to catch fatal errors and execute of the planned activities.
	*/
	public static function shutdownHandler(){
		$error = error_get_last();
		if(in_array($error['type'], [
			E_ERROR,
			E_CORE_ERROR,
			E_COMPILE_ERROR,
			E_PARSE,
			E_RECOVERABLE_ERROR,
			E_USER_ERROR
		], true)){
			$e = new ErrorException($error['message'], 0, $error['type'], $error['file'], $error['line']);
			if(function_exists('xdebug_get_function_stack')){
				$stack = [];
				foreach(array_slice(array_reverse(xdebug_get_function_stack()), 2, -1) as $row){
					$frame = [
						'file' => $row['file'],
						'line' => $row['line'],
						'function' => $row['function'] ? $row['function'] : '*unknown*',
						'args' => [],
					];
					if(!empty($row['class'])){
						$frame['type'] = isset($row['type']) && $row['type'] === 'dynamic' ? '->' : '::';
						$frame['class'] = $row['class'];
					}
					$stack[] = $frame;
				}
				$ref = new ReflectionProperty('Exception', 'trace');
				$ref->setAccessible(true);
				$ref->setValue($e, $stack);
			}
			static::exceptionHandler($e, false);
		}
	}
	/*
	Handler to catch uncaught exception.
	*/
	public static function exceptionHandler($exception, $exit = null){
    if(!isset($exit)){
			$exit = true;
		}
		if(!headers_sent()){
			http_response_code(
				(isset($_SERVER['HTTP_USER_AGENT']) && find('MSIE ', $_SERVER['HTTP_USER_AGENT']) >= 0) ? 503 : 500
			);
		}
		if(ZConfig::config("KERNEL_WRITE_LOG", "true") == "true"){
			$l = new ZLogger();
			$l->error("Exception throw: ".$exception->getMessage()." at ".$exception->getFile()." on line ".$exception->getLine());
		}
		if(preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/i", ZConfig::config("KERNEL_SEND_EMAIL", "false"))){
			mail(
				ZConfig::config("KERNEL_SEND_EMAIL", "false"),
				"Exception throw",
				"Exception throw: ".$exception->getMessage()." at ".$exception->getFile()." on line ".$exception->getLine()
			);
		}
	}
	/*
	Handler to catch warnings and notices.
	*/
	public static function errorHandler($severity, $message, $file, $line, $context){
		if($severity === E_RECOVERABLE_ERROR || $severity === E_USER_ERROR){
			$e = new ErrorException($message, 0, $severity, $file, $line);
			$e->context = $context;
      throw $e;
		}
		return false;
	}
}

if(ZConfig::config("KERNEL_ENABLE", "true") == "true"){
	ZKernel::enable();
}
