<?php
namespace Cvy\Utils\Hooks;

if ( ! defined( 'ABSPATH' ) ) exit;

trait tHookable
{
  final static public function add_filter( string $filter_name, callable $cb, int $priority = 10 ) : void
  {
    add_filter( static::prefix_hook_name( $filter_name ), $cb, $priority, 10 );
  }

  final static public function add_action( string $action_name, callable $cb, int $priority = 10 ) : void
  {
    add_action( static::prefix_hook_name( $action_name ), $cb, $priority, 10 );
  }

  final static public function apply_filters( string $filter_name, mixed $value, mixed ...$args ) : mixed
  {
    $args = [
      static::prefix_hook_name( $filter_name ),
      $value,
      ...static::get_hook_base_args(),
      ...$args
    ];

    return static::has_parent_hookable() ?
      static::get_parent_hookable()->apply_filters( ...$args ) :
      apply_filters( ...$args );
  }

  final static public function do_action( string $action_name, mixed ...$args ) : mixed
  {
    $args = [
      static::prefix_hook_name( $action_name ),
      ...static::get_hook_base_args(),
      ...$args
    ];

    return static::has_parent_hookable() ?
      static::get_parent_hookable()->do_action( ...$args ) :
      do_action( ...$args );
  }

  abstract static protected function get_hook_base_args() : array;

  static private function prefix_hook_name( string $hook_name ) : string
  {
    return '' . static::get_hook_name_prefix() . $hook_name;
  }

  abstract static protected function get_hook_name_prefix() : string;

  static private function has_parent_hookable() : bool
  {
    return ! empty( static::get_parent_hookable() );
  }

  abstract static protected function get_parent_hookable() : iHookable | null;
}