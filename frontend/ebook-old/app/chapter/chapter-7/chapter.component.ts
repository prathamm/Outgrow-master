import { Component } from '@angular/core';

@Component({
	selector: 'chapter',
	templateUrl: 'app/chapter/chapter-7/chapter.component.html'
})

export class ChapterSevenComponent {

	goBack() {
		window.history.back();
	}
}
