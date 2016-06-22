"use strict";
var __decorate = (this && this.__decorate) || function (decorators, target, key, desc) {
    var c = arguments.length, r = c < 3 ? target : desc === null ? desc = Object.getOwnPropertyDescriptor(target, key) : desc, d;
    if (typeof Reflect === "object" && typeof Reflect.decorate === "function") r = Reflect.decorate(decorators, target, key, desc);
    else for (var i = decorators.length - 1; i >= 0; i--) if (d = decorators[i]) r = (c < 3 ? d(r) : c > 3 ? d(target, key, r) : d(target, key)) || r;
    return c > 3 && r && Object.defineProperty(target, key, r), r;
};
var core_1 = require('@angular/core');
var router_deprecated_1 = require('@angular/router-deprecated');
var mock_chapters_1 = require('./../chapter/mock-chapters');
var HeaderComponent = (function () {
    function HeaderComponent() {
    }
    HeaderComponent.prototype.onSelect = function (chapter) {
        this.currentChapter = {
            currentChapter: mock_chapters_1.CHAPTERS[chapter.id - 1],
            prevChapter: mock_chapters_1.CHAPTERS[chapter.id - 2],
            nextChapter: mock_chapters_1.CHAPTERS[chapter.id]
        };
    };
    __decorate([
        core_1.Input()
    ], HeaderComponent.prototype, "currentChapter");
    HeaderComponent = __decorate([
        core_1.Component({
            selector: 'header',
            templateUrl: 'app/header/header.component.html',
            directives: [router_deprecated_1.RouterLink]
        })
    ], HeaderComponent);
    return HeaderComponent;
}());
exports.HeaderComponent = HeaderComponent;
//# sourceMappingURL=header.component.js.map