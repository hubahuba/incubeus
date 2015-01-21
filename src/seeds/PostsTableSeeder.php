<?php

class PostsTableSeeder extends Seeder {

	/**
	 * Auto generated seed file
	 *
	 * @return void
	 */
	public function run()
	{
		\DB::table('posts')->delete();
        
		\DB::table('posts')->insert(array (
			0 => 
			array (
				'id' => 1,
				'template' => 'home.blade.php',
				'title' => 'Home',
				'slug' => '/',
				'post' => NULL,
				'excerpt' => NULL,
				'feature_image' => NULL,
				'type' => 'page',
				'status' => 'pub',
				'creator' => 1,
				'publish_date' => '2015-01-15 00:00:00',
				'created_at' => '2015-01-15 15:39:38',
				'updated_at' => '2015-01-15 16:26:41',
			),
			1 => 
			array (
				'id' => 2,
				'template' => 'post-detail.blade.php',
				'title' => 'Hello, World!',
				'slug' => 'hello-world',
				'post' => '<p>A &quot;Hello, world!&quot; program has become the traditional first program that many people learn. In general, it is simple enough so that people who have no experience with computer programming can easily understand it, especially with the guidance of a teacher or a written guide. Using this simple program as a basis, computer science principles or elements of a specific programming language can be explained to novice programmers. Experienced programmers learning new languages can also gain a lot of information about a given language&#39;s syntax and structure from a &quot;Hello, world!&quot; program.</p>

<p>In addition, &quot;Hello, world!&quot; can be a useful sanity test to make sure that a language&#39;s compiler, development environment, and run-time environment are correctly installed. Configuring a complete programming toolchain from scratch to the point where even trivial programs can be compiled and run can involve substantial amounts of work. For this reason, a simple program is used first when testing a new tool chain.<br />
A &quot;Hello, world!&quot; program running on Sony&#39;s PlayStation Portable as a proof of concept.<br />
&quot;Hello, world!&quot; is also used by computer hackers as a proof of concept that arbitrary code can be executed through an exploit where the system designers did not intend code to be executed&mdash;for example, on Sony&#39;s PlayStation Portable. This is the first step in using homemade content (&quot;home brew&quot;) on such a device.</p>
',
				'excerpt' => 'In addition, "Hello, world!" can be a useful sanity test to make sure that a language\'s compiler, development environment, and run-time environment are correctly installed.',
				'feature_image' => NULL,
				'type' => 'post',
				'status' => 'pub',
				'creator' => 1,
				'publish_date' => '2015-01-15 03:00:00',
				'created_at' => '2015-01-15 17:41:27',
				'updated_at' => '2015-01-15 18:15:51',
			),
			2 => 
			array (
				'id' => 3,
				'template' => 'category-post.blade.php',
				'title' => 'Category',
				'slug' => 'category',
				'post' => NULL,
				'excerpt' => NULL,
				'feature_image' => NULL,
				'type' => 'page',
				'status' => 'pub',
				'creator' => 1,
				'publish_date' => '2015-01-15 00:00:00',
				'created_at' => '2015-01-15 18:10:18',
				'updated_at' => '2015-01-15 18:10:18',
			),
		));
	}

}
