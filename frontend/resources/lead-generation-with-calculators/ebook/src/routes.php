<?php
// Routes

$app->get('/', function ($request, $response) {
	$first_chapter = array_keys($this->chapters)[0];
    $previous_chapter_path = $first_chapter;
    $next_chapter_path = array_keys($this->chapters)[1];

    return $this->view->render($response, 'chapter.php', [
    	'chapters' => $this->chapters,
    	'this_chapter'=>$this->chapters[$first_chapter],
        'previous_chapter_path'=>$previous_chapter_path,
        'next_chapter_path'=>$next_chapter_path
    ]);
})->setName('index');


$app->get('/chapter/{path}', function ($request, $response, $args) {
    $path = $args['path'];

    $chapter_keys = array_keys($this->chapters);
    $total_chapters = count($this->chapters);

    $first_chapter = $chapter_keys[0];
    $previous_chapter_path = $first_chapter;
    $next_chapter_path = $chapter_keys[$total_chapters - 1];

    $chapter = $this->chapters[$first_chapter];
    array_push($chapter, $first_chapter);

    if(false !== ($index = array_search($path, $chapter_keys))) {
        
        $chapter = $this->chapters[$path];

        if($index < $total_chapters - 1) {
            $next_index = $index + 1;
            $next_chapter_path = $chapter_keys[$next_index];
        }

        if($index > 0) {
            $prev_index = $index - 1;
            $previous_chapter_path = $chapter_keys[$prev_index];
        }
    }

    // Render chapters view
    if($request->isXhr()) {
    	$template = $this->view->fetch($chapter['template']);

    	die(json_encode([
    		'template' => $template,
    		'title' => $chapter['name'],
    		'success' => true
    	]));
    }
    else {
	    return $this->view->render($response, 'chapter.php', [
	    	'chapters' => $this->chapters,
	    	'this_chapter'=>$chapter,
            'this_chapter_path'=>$path,
            'previous_chapter_path'=>$previous_chapter_path,
            'next_chapter_path'=>$next_chapter_path
	    ]);
	}
})->setName('chapter');
