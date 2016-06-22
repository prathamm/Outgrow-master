import { Component } from '@angular/core';

@Component({
	selector: 'chapter',
	templateUrl: 'app/chapter/chapter-3/chapter.component.html'
})

export class ChapterThreeComponent {

	goBack() {
		window.history.back();
	}
}
