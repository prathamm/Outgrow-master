import { Component } from '@angular/core';

@Component({
	selector: 'chapter',
	templateUrl: 'app/chapter/chapter-4/chapter.component.html'
})

export class ChapterFourComponent {

	goBack() {
		window.history.back();
	}
}
