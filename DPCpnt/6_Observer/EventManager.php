<?php namespace Psr\EventManager;

//use Psr\EventManager\EventInterface;
//Use Psr\EventManager\EventManagerInterface;


/**
 * Class EventManager
 * @package Gc7
 */
class EventManager implements EventManagerInterface {

	/**
	 * @var array
	 */
	private $listeners = [ ];

	/**
	 * Attaches a listener to an event
	 *
	 * @param string   $event    the event to attach too
	 * @param callable $callback a callable function
	 * @param int      $priority the priority at which the $callback executed
	 *
	 * @return bool true on success false on failure
	 */
	public function attach ( $event, $callback, $priority = 0 ) {
		$this->listeners[ $event ][] = [
			'callback' => $callback,
			'priority' => $priority
		];

		return TRUE;
	}

	/**
	 * Detaches a listener from an event
	 *
	 * @param string   $event    the event to attach too
	 * @param callable $callback a callable function
	 *
	 * @return bool true on success false on failure
	 */
	public function detach ( $event, $callback ) {

		$this->listeners[ $event ] = array_filter( $this->listeners[ $event ], function ( $listener ) use ( $callback ) {
			return $listener[ 'callback' ] !== $callback;
		} );

		return TRUE;

	}

	/**
	 * Clear all listeners for a given event
	 *
	 * @param  string $event
	 *
	 * @return void
	 */
	public function clearListeners ( $event ) {
		$this->listeners[ $event ] = [ ];
	}

	/**
	 * Trigger an event
	 *
	 * Can accept an EventInterface or will create one if not passed
	 *
	 * @param  string|EventInterface $event
	 * @param  object|string         $target
	 * @param  array|object          $argv
	 *
	 * @return mixed
	 */
	public function trigger ( $event, $target = null, $argv = [ ] ) {
		if ( is_string( $event ) ) {
			$event = $this->makeEvent( $event, $target, $argv );
		}
		if ( isset( $this->listeners[ $event->getName() ] ) ) {
			$listeners = $this->listeners[ $event->getName() ];

			usort( $listeners, function ( $listenerA, $listenerB ) {
				return $listenerB[ 'priority' ] - $listenerA[ 'priority' ];
			} );

			foreach ( $listeners as [ 'callback' => $callback ] ) {
				call_user_func( $callback, $event );
			}
			
		}
	}

	/**
	 * @param string $eventName
	 * @param null   $target
	 * @param array  $args
	 *
	 * @return EventInterface
	 */
	private function makeEvent ( string $eventName, $target = null, array $args = [ ] ):EventInterface {

		$event = new Event();
		$event->setName( $eventName );
		$event->setTarget( $target );
		$event->setParams( $args );

	}
}
