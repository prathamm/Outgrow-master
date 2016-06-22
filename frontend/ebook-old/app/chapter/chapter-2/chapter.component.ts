import { Component } from '@angular/core';

@Component({
	selector: 'chapter',
	templateUrl: 'app/chapter/chapter-2/chapter.component.html'
})

export class ChapterTwoComponent {

	goBack() {
		window.history.back();
	}
}
