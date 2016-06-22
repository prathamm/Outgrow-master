import { Component } from '@angular/core';

@Component({
	selector: 'chapter',
	templateUrl: 'app/chapter/chapter-5/chapter.component.html'
})

export class ChapterFiveComponent {

	goBack() {
		window.history.back();
	}
}
