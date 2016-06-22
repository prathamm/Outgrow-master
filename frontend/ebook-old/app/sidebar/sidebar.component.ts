import { Component, Input } from '@angular/core';
import { RouterLink } from '@angular/router-deprecated';

import { Chapter } from './../chapter/chapter';
import { CHAPTERS } from './../chapter/mock-chapters';
import { CurrentChapter } from './../chapter/current-chapter';

@Component({
	selector: 'sidebar',
	templateUrl: 'app/sidebar/sidebar.component.html',
	directives: [RouterLink]
})

export class SidebarComponent {
	chapters: Chapter[] = CHAPTERS;

	@Input()
	currentChapter: CurrentChapter;

	onSelect(chapter) {
		this.currentChapter = {
			currentChapter: CHAPTERS[chapter.id -1],
			prevChapter: CHAPTERS[chapter.id - 2],
			nextChapter: CHAPTERS[chapter.id]
		};
	}
}
