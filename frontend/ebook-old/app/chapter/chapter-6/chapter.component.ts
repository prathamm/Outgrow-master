import { Component } from '@angular/core';

@Component({
	selector: 'chapter',
	templateUrl: 'app/chapter/chapter-6/chapter.component.html'
})

export class ChapterSixComponent {

	goBack() {
		window.history.back();
	}
}
