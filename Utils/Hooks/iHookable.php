<?php
namespace Cvy\Utils\Hooks;

if ( ! defined( 'ABSPATH' ) ) exit;

interface iHookable
{
  static public function add_filter( string $filter_name, callable $cb, int $priority = 10 ) : void;

  static public function add_action( string $action_name, callable $cb, int $priority = 10 ) : void;

  static public function apply_filters( string $filter_name, mixed $value, mixed ...$args ) : mixed;

  static public function do_action( string $action_name, mixed ...$args ) : mixed;
}