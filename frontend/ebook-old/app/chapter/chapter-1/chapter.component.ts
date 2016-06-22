import { Component } from '@angular/core';

@Component({
	selector: 'chapter',
	templateUrl: 'app/chapter/chapter-1/chapter.component.html'
})

export class ChapterOneComponent {

	goBack() {
		window.history.back();
	}
}
