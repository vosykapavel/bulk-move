<?php

namespace BulkWP\BulkMove\Core;

use BulkWP\Tests\WPMock\WPMockTestCase;

/**
 * Test BulkMove.
 *
 * TODO: Add tests for autoloader
 * TODO: Add tests for plugin_file
 * TODO: Add tests for setting translations path
 */
class BulkMoveTest extends WPMockTestCase {

	protected $test_files = [
		'/include/Core/BulkMove.php',
	];

	function test_it_is_singleton() {
		$a = BulkMove::get_instance();
		$b = BulkMove::get_instance();

		$this->assertSame( $a, $b );
	}

	function test_if_cone_is_not_supported() {
		\WP_Mock::userFunction( '_doing_it_wrong', array(
			'times' => 1,
		) );

		$bulk_move = BulkMove::get_instance();
		clone $bulk_move;

		$this->assertConditionsMet();
	}

	function test_if_wakeup_is_not_supported() {
		\WP_Mock::userFunction( '_doing_it_wrong', array(
			'times' => 1,
		) );

		$bulk_move = BulkMove::get_instance();
		unserialize( serialize( $bulk_move ) );

		$this->assertConditionsMet();
	}

	function test_load_action() {
		\WP_Mock::expectAction( 'bm_loaded' );

		$bulk_move = BulkMove::get_instance();
		$bulk_move->load();

		$this->assertConditionsMet();
	}

	/**
	 * Test if translations are loaded.
	 *
	 * Skipped for now till the dependencies are resolved.
	 */
	public function test_translation_is_loaded() {
		self::markTestSkipped( 'Skipping this for now.' );

		\WP_Mock::userFunction( 'load_plugin_textdomain', array(
			'times' => 1,
			'args' => array( 'bulk-move', false, \WP_Mock\Functions::type( 'string' ) )
		) );

		$bulk_move = BulkMove::get_instance();
		$bulk_move->on_init();

		$this->assertConditionsMet();
	}
}
