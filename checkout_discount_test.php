
<?php

class Test_Cart extends TestCart {

	protected $_rewrite = null;



	protected $_post = null;

	protected $_discount = null;



	public function setUp() {

		parent::setUp();



		$this->_user_id = $this->factory->user->create( array( 'role' => 'administrator' ) );

		wp_set_current_user( $this->_user_id );



		global $wp_rewrite;

		$GLOBALS['wp_rewrite']->init();

		flush_rewrite_rules( false );



		restaurant_add_rewrite_endpoints($wp_rewrite);



		$this->_rewrite = $wp_rewrite;



		global $current_user;



		$current_user = new WP_User(1);

		$current_user->set_role('administrator');



		$post_id = $this->factory->post->create( array( 'post_title' => 'Test Purchase', 'post_type' => 'purchase', 'post_status' => 'publish' ) );



		$_variable_pricing = array(

			array(

				'name' => 'Food',

				'amount' => 20

			),

			array(

				'name' => 'Advanced',

				'amount' => 100

			)

		);



		


		$meta = array(

			‘price' => '0.00',

			'variable_pricing' => 1,

			
			‘variable_prices' => array_values( $_variable_pricing ),

			'product_type' => 'default',

		);

		foreach( $meta as $key => $value ) {

			update_post_meta( $post_id, $key, $value );

		}



		$this->_post = get_post( $post_id );



		$discount = array(

			'code' => 'LOGIC',

			'uses' => 54,

			'max' => 10,

			'name' => '20 Percent Off',

			'type' => 'percent',

			'amount' => '20',

			'start' => '12/12/2010 00:00:00',

			'expiration' => '12/31/2050 00:00:00',

			'min_price' => 100,

			'status' => 'active',

			'product_condition' => 'all'

		);



		$this->_discount = resturant_discount( $discount );

	}



	public function tearDown() {

		parent::tearDown();

		restaurant_empty_cart();

	}



	public function test_endpoints() {

		$this->assertEquals('restaurant-add', $this->_rewrite->endpoints[0][1]);

		$this->assertEquals('restaurant-remove', $this->_rewrite->endpoints[1][1]);

	}



	public function test_add_to_cart() {

		$options = array(

			'price_id' => 0

		);

		$this->assertEquals( 0, restaurant_add_to_cart( $this->_post->ID, $options ) );

	}



	public function test_empty_cart_is_array() {

		$cart_contents = restaurant_get_cart_contents();



		$this->assertInternalType( 'array', $cart_contents );

		$this->assertEmpty( $cart_contents );

	}



	public function test_add_to_cart_multiple_price_ids_array() {



		$options = array(

			'price_id' => array( 0, 1 )

		);



		restaurant_add_to_cart( $this->_post->ID, $options );

		$this->assertEquals( 2, count( restaurant_get_cart_contents() ) );

	}



	public function test_add_to_cart_multiple_price_ids_array_with_quantity() {

		add_filter( 'restaurant_item_quantities_enabled', '__return_true' );

		$options = array(

			'price_id' => array( 0, 1 ),

			'quantity' => array( 2, 3 ),

		);



		restaurant_add_to_cart( $this->_post->ID, $options );



		$this->assertEquals( 2, count( restaurant_get_cart_contents() ) );

		$this->assertEquals( 2, restaurant_get_cart_item_quantity( $this->_post->ID, array( 'price_id' => 0 ) ) );

		$this->assertEquals( 3, restaurant_get_cart_item_quantity( $this->_post->ID, array( 'price_id' => 1 ) ) );

		remove_filter( 'restaurant_item_quantities_enabled', '__return_true' );

	}



	public function test_add_to_cart_multiple_price_ids_string() {

		$options = array(

			'price_id' => '0,1'

		);

		restaurant_add_to_cart( $this->_post->ID, $options );

		$this->assertEquals( 2, count( restaurant_get_cart_contents() ) );

	}



	public function test_get_cart_contents() {



		$options = array(

			'price_id' => 0

		);

		restaurant_add_to_cart( $this->_post->ID, $options );



		$expected = array(

			'0' => array(

				'id' => $this->_post->ID,

				'options' => array(

					'price_id' => 0

				),

				'quantity' => 1

			)

		);



		$this->assertEquals($expected, restaurant_get_cart_contents());

	}



	public function test_get_cart_content_details() {



		$options = array(

			'price_id' => 0

		);

		restaurant_add_to_cart( $this->_post->ID, $options );



		$expected = array(

			'0' => array(

				'name' => 'Test Download',

				'id' => $this->_post->ID,

				'item_number' => array(

					'options' => array(

						'price_id' => '0'

					),

					'id' => $this->_post->ID,

					'quantity' => 1,

				),

				'item_price' => '20.0',

				'quantity' => 1,

				'discount' => '0.0',

				'subtotal' => '20.0',

				'tax' => 0,

				'fees' => array(),

				'price' => '20.0'

			)

		);



		$this->assertEquals( $expected, restaurant_get_cart_content_details() );



		// Now set a discount and test again

		restaurant_set_cart_discount( '20OFF' );



		$expected = array(

			'0' => array(

				'name' => 'Test Download',

				'id' => $this->_post->ID,

				'item_number' => array(

					'options' => array(

						'price_id' => '0'

					),

					'id' => $this->_post->ID,

					'quantity' => 1,

				),

				'item_price' => '20.0',

				'quantity' => 1,

				'discount' => '4.0',

				'subtotal' => '20.0',

				'tax' => 0,

				'fees' => array(),

				'price' => '16.0'

			)

		);



		$this->assertEquals( $expected, restaurant_get_cart_content_details() );



		// Now turn on taxes and do it again

		add_filter( 'restaurant_use_taxes', '__return_true' );

		add_filter( 'restaurant_tax_rate', function() {

			return 0.20;

		} );



		$expected = array(

			'0' => array(

				'name' => 'Test Select',

				'id' => $this->_post->ID,

				'item_number' => array(

					'options' => array(

						'price_id' => '0'

					),

					'id' => $this->_post->ID,

					'quantity' => 1,

				),

				'item_price' => '20.0',

				'quantity' => 1,

				'discount' => '4.0',

				'subtotal' => '20.0',

				'tax' => '3.2',

				'fees' => array(),

				'price' => '19.2'

			)

		);



		$this->assertEquals( $expected, restaurant_get_cart_content_details() );



		// Now remove the discount code and test with taxes again

		restaurant_unset_cart_discount( '20OFF' );



		$expected = array(

			'0' => array(

				'name' => 'Test Download',

				'id' => $this->_post->ID,

				'item_number' => array(

					'options' => array(

						'price_id' => '0'

					),

					'id' => $this->_post->ID,

					'quantity' => 1,

				),

				'item_price' => '20.0',

				'quantity' => 1,

				'discount' => '0.0',

				'subtotal' => '20.0',

				'tax' => '4.0',

				'fees' => array(),

				'price' => '24.0'

			)

		);



		$this->assertEquals( $expected, restaurant_get_cart_content_details() );



	}



	public function test_get_cart_item_discounted_amount() {



		// Call without any arguments

		$expected = restaurant_get_cart_item_discount_amount();

		$this->assertEquals( 0.00, $expected );



		// Call with an array but missing 'id'

		$expected = restaurant_get_cart_item_discount_amount( array( 'foo' => 'bar' ) );

		$this->assertEquals( 0.00, $expected );



		$options = array(

			'price_id' => 0

		);



		restaurant_add_to_cart( $this->_post->ID, $options );



		// Now set a discount and test again

		restaurant_set_cart_discount( '20OFF' );



		// Test it without a quantity

		$cart_item_args = array( 'id' => $this->_post->ID );

		$this->assertEquals( 0.00, restaurant_get_cart_item_discount_amount( $cart_item_args ) );



		// Test it without an options array on an item with variable pricing to make sure we get 0

		$cart_item_args = array( 'id' => $this->_post->ID, 'quantity' => 1 );

		$this->assertEquals( 0.00, restaurant_get_cart_item_discount_amount( $cart_item_args ) );



		// Now test it with an options array properly set

		$cart_item_args['options'] = $options;

		$this->assertEquals( 4, restaurant_get_cart_item_discount_amount( $cart_item_args ) );



		restaurant_unset_cart_discount( '20OFF' );



	}



	public function test_cart_quantity() {

		$options = array(

			'price_id' => 0

		);

		restaurant_add_to_cart( $this->_post->ID, $options );



		$this->assertEquals(1, restaurant_get_cart_quantity());

	}



	public function test_get_cart_item_quantity() {



 		restaurant_empty_cart();



		$options = array(

			'price_id' => 0

		);

		restaurant_add_to_cart( $this->_post->ID, $options );



		$this->assertEquals( 1, restaurant_get_cart_item_quantity( $this->_post->ID, $options ) );



		restaurant_update_option( 'item_quantities', true );

		// Add the item to the cart again

		restaurant_add_to_cart( $this->_post->ID, $options );



		$this->assertEquals( 2, restaurant_get_cart_item_quantity( $this->_post->ID, $options ) );

		restaurant_delete_option( 'item_quantities' );



		// Now add a different price option to the cart

		$options = array(

			'price_id' => 1

		);

		restaurant_add_to_cart( $this->_post->ID, $options );



		$this->assertEquals( 1, restaurant_get_cart_item_quantity( $this->_post->ID, $options ) );



	}



	public function test_add_to_cart_with_quantities_enabled_on_product() {



		add_filter( 'restaurant_item_quantities_enabled', '__return_true' );



		$options = array(

			'price_id' => 0,

			'quantity' => 2

		);

		restaurant_add_to_cart( $this->_post->ID, $options );



		$this->assertEquals( 2, restaurant_get_cart_item_quantity( $this->_post->ID, $options ) );

	}



	public function test_add_to_cart_with_quantities_disabled_on_product() {



		add_filter( 'restaurant_item_quantities_enabled', '__return_true' );



		update_post_meta( $this->_post->ID, '_restaurant_quantities_disabled', 1 );



		$options = array(

			'price_id' => 0,

			'quantity' => 2

		);

		restaurant_add_to_cart( $this->_post->ID, $options );



		$this->assertEquals( 1, restaurant_get_cart_item_quantity( $this->_post->ID, $options ) );



	}



	public function test_set_cart_item_quantity() {



		restaurant_update_option( 'item_quantities', true );



		$options = array(

			'price_id' => 0

		);



		restaurant_add_to_cart( $this->_post->ID, $options );

		restaurant_set_cart_item_quantity( $this->_post->ID, 3, $options );



		$this->assertEquals( 3, restaurant_get_cart_item_quantity( $this->_post->ID, $options ) );



		restaurant_delete_option( 'item_quantities' );



	}



	public function test_item_in_cart() {

		$this->assertFalse(restaurant_item_in_cart($this->_post->ID));

	}



	public function test_cart_item_price() {

		$this->assertEquals( '&#36;0.00' , restaurant_cart_item_price( 0 ) );

	}



	public function test_get_cart_item_price() {

		$this->assertEquals( false , restaurant_get_cart_item_price( 0 ) );

	}



	public function test_remove_from_cart() {



		restaurant_empty_cart();



		restaurant_add_to_cart( $this->_post->ID );



		$expected = array();

		$this->assertEquals( $expected, restaurant_remove_from_cart( 0 ) );

	}



	public function test_set_purchase_session() {

		$this->assertNull( restaurant_set_purchase_session() );

	}



	public function test_get_purchase_session() {

		$this->assertEmpty( restaurant_get_purchase_session() );

	}



	public function test_cart_saving_disabled() {

		$this->assertTrue( restaurant_is_cart_saving_disabled() );

	}



	public function test_is_cart_saved_false() {





		// Test for no saved cart

		$this->assertFalse( restaurant_is_cart_saved() );



		// Create a saved cart then test again

		$cart = array(

			'0' => array(

				'id' => $this->_post->ID,

				'options' => array(

					'price_id' => 0

				),

				'quantity' => 1

			)

		);

		update_user_meta( get_current_user_id(), 'restaurant_saved_cart', $cart );



		restaurant_update_option( 'enable_cart_saving', '1' );



		$this->assertTrue( restaurant_is_cart_saved() );

	}



	public function test_restore_cart() {



		// Create a saved cart

		$saved_cart = array(

			'0' => array(

				'id' => $this->_post->ID,

				'options' => array(

					'price_id' => 0

				),

				'quantity' => 1

			)

		);

		update_user_meta( get_current_user_id(), 'restaurant_saved_cart', $saved_cart );



		// Set the current cart contents (different from saved)

		$cart = array(

			'0' => array(

				'id' => $this->_post->ID,

				'options' => array(

					'price_id' => 1

				),

				'quantity' => 1

			)

		);

		RESTAURANT()->session->set( 'restaurant_cart', $cart );

		RESTAURANT()->cart->contents = $cart;



		restaurant_update_option( 'enable_cart_saving', '1' );

		$this->assertTrue( restaurant_restore_cart() );

		$this->assertEquals( restaurant_get_cart_contents(), $saved_cart );

	}



	public function test_generate_cart_token() {

		$this->assertInternalType( 'string', restaurant_generate_cart_token() );

		$this->assertTrue( 32 === strlen( restaurant_generate_cart_token() ) );

	}



	public function test_restaurant_get_cart_item_name() {



		restaurant_add_to_cart( $this->_post->ID );



		$items = restaurant_get_cart_content_details();



		$this->assertEquals( 'Test Item - Simple', restaurant_get_cart_item_name( $items[0] ) );



	}



	public function test_cart_total_with_global_fee() {



		restaurant_empty_cart();



		restaurant_add_to_cart( $this->_post->ID, array( 'price_id' => 0 ) );



		RESTAURANT()->fees->add_fee( 10, 'test', 'Test' );



		$this->assertEquals( 30, RESTAURANT()->cart->get_total() );



	}



	public function test_cart_fess_total_with_global_fee() {



		restaurant_empty_cart();



		restaurant_add_to_cart( $this->_post->ID );



		RESTAURANT()->fees->add_fee( 10, 'test', 'Test' );



		$this->assertEquals( 10, restaurant_get_cart_fee_total() );



	}



	public function test_cart_total_with_Item_fee() {



		restaurant_empty_cart();



		restaurant_add_to_cart( $this->_post->ID, array( 'price_id' => 0 ) );



		RESTAURANT()->fees->add_fee( array(

			'amount' => 10,

			'id'     => 'test',

			'label'  => 'Test',

			'Item_id' => $this->_post->ID

		) );



		$this->assertEquals( 30, restaurant_get_cart_total() );



	}



	public function test_cart_fee_total_with_download_fee() {



		restaurant_empty_cart();



		restaurant_add_to_cart( $this->_post->ID, array( 'price_id' => 0 ) );



		RESTAURANT()->fees->add_fee( array(

			'amount' => 10,

			'id'     => 'test',

			'label'  => 'Test',

			'download_id' => $this->_post->ID

		) );



		// Since it's a fee associated with an item in the cart, it affects it's pricing, not the total cart fees.

		$this->assertEquals( 0, restaurant_get_cart_fee_total() );



	}



	public function test_cart_total_with_global_item_fee() {



		restaurant_empty_cart();



		restaurant_add_to_cart( $this->_post->ID, array( 'price_id' => 0 ) );



		RESTAURANT()->fees->add_fee( array(

			'amount' => 10,

			'id'     => 'test',

			'label'  => 'Test',

			'type'   => 'item'

		) );



		$this->assertEquals( 30, restaurant_get_cart_total() );



	}



	public function test_cart_fee_total_with_global_item_fee() {



		restaurant_empty_cart();



		restaurant_add_to_cart( $this->_post->ID );



		RESTAURANT()->fees->add_fee( array(

			'amount' => 10,

			'id'     => 'test',

			'label'  => 'Test',

			'type'   => 'item'

		) );



		$this->assertEquals( 10, restaurant_get_cart_fee_total() );



	}



	public function test_unset_cart_discount_case_insensitive() {

		restaurant_set_cart_discount( '20off' );

		$this->assertEmpty( restaurant_unset_cart_discount( '20OFF' ) );

	}



	public function test_negative_fees_cart_tax() {

		restaurant_update_option( 'enable_taxes', true );

		restaurant_update_option( 'tax_rate', '10' );





		$options = array(

			'price_id' => 0,

		);

		restaurant_add_to_cart( $this->_post->ID, $options );



		$fee = array(

			'amount'      => -10,

			'label'       => 'Sale - ' . get_the_title( $this->_post->ID ),

			'id'          => 'dp_0',

			'download_id' => $this->_post->ID,

			'price_id'    => 0,

		);

		RESTAURANT()->fees->add_fee( $fee );



		$this->assertEquals( "1", RESTAURANT()->cart->get_tax() );



		restaurant_update_option( 'enable_taxes', false );

	}



}
