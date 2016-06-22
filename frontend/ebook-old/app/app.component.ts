import { Component } from '@angular/core';
import { RouteConfig, ROUTER_DIRECTIVES, ROUTER_PROVIDERS } from '@angular/router-deprecated';

import { HeaderComponent } from './header/header.component';
import { SidebarComponent } from './sidebar/sidebar.component';

import { CHAPTERS } from './chapter/mock-chapters';
import { Chapter } from './chapter/chapter';
import { CurrentChapter } from './chapter/current-chapter';

import { ChapterOneComponent } from './chapter/chapter-1/chapter.component';
import { ChapterTwoComponent } from './chapter/chapter-2/chapter.component';
import { ChapterThreeComponent } from './chapter/chapter-3/chapter.component';
import { ChapterFourComponent } from './chapter/chapter-4/chapter.component';
import { ChapterFiveComponent } from './chapter/chapter-5/chapter.component';
import { ChapterSixComponent } from './chapter/chapter-6/chapter.component';
import { ChapterSevenComponent } from './chapter/chapter-7/chapter.component';

@Component({
  selector: 'my-app',
  template: `
	  	<header [currentChapter]="thisChapter"></header>
		<sidebar [currentChapter]="thisChapter"></sidebar>
		<router-outlet></router-outlet>
	`,
  directives: [HeaderComponent, SidebarComponent, ROUTER_DIRECTIVES],
  providers: [ROUTER_PROVIDERS]
})

@RouteConfig([
	{
		path: '/',
		name: 'Home',
		component: ChapterOneComponent,
		useAsDefault: true
	},
	{
		path: '/chapter/' + CHAPTERS[0].path,
		name: 'Chapter-1',
		component: ChapterOneComponent
	},
	{
		path: '/chapter/' + CHAPTERS[1].path,
		name: 'Chapter-2',
		component: ChapterTwoComponent
	},
	{
		path: '/chapter/' + CHAPTERS[2].path,
		name: 'Chapter-3',
		component: ChapterThreeComponent
	},
	{
		path: '/chapter/' + CHAPTERS[3].path,
		name: 'Chapter-4',
		component: ChapterFourComponent
	},
	{
		path: '/chapter/' + CHAPTERS[4].path,
		name: 'Chapter-5',
		component: ChapterFiveComponent
	},
	{
		path: '/chapter/' + CHAPTERS[5].path,
		name: 'Chapter-6',
		component: ChapterSixComponent
	},
	{
		path: '/chapter/' + CHAPTERS[6].path,
		name: 'Chapter-7',
		component: ChapterSevenComponent
	}
])

export class AppComponent {
	thisChapter: CurrentChapter = {
		currentChapter: CHAPTERS[0],
		prevChapter: CHAPTERS[0],
		nextChapter: CHAPTERS[1]
	};
}
