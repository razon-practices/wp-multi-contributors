<?php

class Test_Slideshow_Admin_Page extends WP_UnitTestCase
{
	/**
	 * Activates the WP Multi Contributors plugin if not already active.
	 *
	 * Ensures the required WordPress functions are available and activates
	 * the `wp-multi-contributors` plugin during test setup if it is not currently active.
	 *
	 * @return void
	 */
	public function activate_wp_multi_contributors_plugin()
	{
		$plugin = 'wp-multi-contributors/wp-multi-contributors.php';

		if (!function_exists('is_plugin_active')) {
			require_once ABSPATH . 'wp-admin/includes/plugin.php';
		}

		if (!is_plugin_active($plugin)) {
			$result = activate_plugin($plugin);
			$this->assertFalse(is_wp_error($result), 'Failed to activate plugin.');
		}
	}

	/**
	 * Create users, posts, and assign contributors.
	 *
	 * @return void
	 */
	public function creating_users_posts()
	{
		$users = [
			['username' => 'admin', 'email' => 'admin@example.com', 'password' => 'demo', 'role' => 'administrator'],
			['username' => 'author', 'email' => 'author@example.com', 'password' => 'demo', 'role' => 'author'],
			['username' => 'editor', 'email' => 'editor@example.com', 'password' => 'demo', 'role' => 'editor'],
			['username' => 'author-2', 'email' => 'author-2@example.com', 'password' => 'demo', 'role' => 'author'],
		];

		$user_ids = [];
		foreach ($users as $user) {
			if (!username_exists($user['username']) && !email_exists($user['email'])) {
				$user_id = wp_create_user($user['username'], $user['password'], $user['email']);
				wp_update_user(['ID' => $user_id, 'role' => $user['role']]);
				$user_ids[$user['username']] = $user_id;
			} else {
				$user = get_user_by('login', $user['username']);
				if ($user) {
					$user_ids[$user->user_login] = $user->ID;
				}
			}
		}

		$this->assertCount(4, $user_ids, 'Failed to create all test users.');

		$posts = [
			['title' => 'Post by Admin', 'author' => $user_ids['admin']],
			['title' => 'Post by Author', 'author' => $user_ids['author']],
			['title' => 'Post by Editor', 'author' => $user_ids['editor']],
		];

		foreach ($posts as $post) {
			$post_id = wp_insert_post([
				'post_title' => $post['title'],
				'post_content' => 'This is a test post by ' . $post['title'],
				'post_status' => 'publish',
				'post_author' => $post['author'],
			]);
			$this->assertIsInt($post_id, 'Failed to create test post: ' . $post['title']);
		}
	}

	/**
	 * Sets up the test environment.
	 *
	 * @return void
	 */
	public function set_up()
	{
		// parent::set_up();
		$this->activate_wp_multi_contributors_plugin();
		$this->creating_users_posts();
	}

	/**
	 * Test updating post meta with contributor data.
	 *
	 * @return void
	 */
	public function test_update_post_meta()
	{
		$users = get_users( array( 'role__in' => array( 'author' ) ) );

		$this->assertNotEmpty($users);

		// get all posts.
		$posts = get_posts( array( 'post_type' => 'post' ) );

		$this->assertIsArray($posts);

		// Get the selected contributors from post meta.
		$authors = update_post_meta(
			$posts[0]->ID,
			'_wpmc_author_list',
			array_column($users, 'ID')
		);

		$found = $authors ? true : false;
		$this->assertTrue($found, 'Failed to update post meta.');
	}

	/**
	 * Test retrieving contributors with specific meta key.
	 *
	 * @return void
	 */
	public function test_get_contributors()
	{
		// get all posts.
		$posts = get_posts( array(
			'post_type' => 'post',
			'meta_query' => array(
				array(
					'key'     => '_wpmc_author_list',
					'compare' => 'EXISTS',
				),
				array(
					'key'     => '_wpmc_author_list',
					'compare' => '!=',
					'value'   => '',
				)
			),
		) );

		// $posts is an array and not empty
		$this->assertNotEmpty($posts, 'No posts found with contributors.');
	}

	/**
	 * Test frontend display of contributors.
	 *
	 * @return void
	 */
	public function test_frontend()
	{
		// get all posts.
		$posts = get_posts( array(
			'post_type' => 'post',
			'meta_query' => array(
				array(
					'key'     => '_wpmc_author_list',
					'compare' => 'EXISTS',
				),
				array(
					'key'     => '_wpmc_author_list',
					'compare' => '!=',
					'value'   => '',
				)
			),
		) );

		foreach ($posts as $post) {
			$authors = get_post_meta($post->ID, '_wpmc_author_list', true);
			$this->assertIsArray($authors, 'Contributor data is not an array for post ID: ' . $post->ID);
			$this->assertNotEmpty($authors, 'No contributors found for post ID: ' . $post->ID);
		}
	}

	/**
	 * Delete all test data created during tests.
	 *
	 * @return void
	 */
	public function test_delete_all_test_data()
	{
		$posts = get_posts(['post_type' => 'post']);
		foreach ($posts as $post) {
			delete_post_meta($post->ID, '_wpmc_author_list');
			wp_delete_post($post->ID, true);
		}

		$users = get_users();
		foreach ($users as $user) {
			wp_delete_user($user->ID);
		}

		$posts = get_posts(['post_type' => 'post']);
		$this->assertEmpty($posts, 'Failed to delete all posts.');

		$users = get_users();
		$this->assertEmpty($users, 'Failed to delete all users.');
	}
}
