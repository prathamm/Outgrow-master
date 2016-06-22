<?php
// Application data

// Get container
$container = $app->getContainer();

// Register component on container
$container['chapters'] = function ($container) {
    $chapters = [
		'introduction' => [
			'name' => 'Introduction',
			'template' => 'chapters/chapter-1.php'
		],
		'why-calculators-work' => [
			'name' => 'Why Calculators Work?',
			'template' => 'chapters/chapter-2.php'
		],
		'what-kind-of-a-calculator-should-i-build' => [
			'name' => 'What kind of a calculator should I build?',
			'template' => 'chapters/chapter-3.php'
		],
		'the-anatomy-of-a-calculator-lp' => [
			'name' => 'Anatomy of a Calculator: Landing Page',
			'template' => 'chapters/chapter-4.php'
		],
		'the-anatomy-of-a-calculator-ques' => [
			'name' => 'Anatomy of a Calculator: Questionnaire',
			'template' => 'chapters/chapter-5.php'
		],
		'the-anatomy-of-a-calculator-results' => [
			'name' => 'Anatomy of a Calculator: Results',
			'template' => 'chapters/chapter-6.php'
		],
		'lead-generation' => [
			'name' => 'Lead Generation',
			'template' => 'chapters/chapter-7.php'
		],
		'optimizing-conversion' => [
			'name' => 'Optimizing Conversion',
			'template' => 'chapters/chapter-8.php'
		],
		'generating-traffic' => [
			'name' => 'Generating Traffic',
			'template' => 'chapters/chapter-9.php'
		],
		'lead-nurturing' => [
			'name' => 'Lead Nurturing',
			'template' => 'chapters/chapter-10.php'
		],
		'final-thoughts' => [
			'name' => 'Final Thoughts',
			'template' => 'chapters/chapter-11.php'
		]
	];

    return $chapters;
};

$container["count"] = 1;
