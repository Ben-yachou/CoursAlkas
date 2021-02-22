import { Component, OnInit, ElementRef, Renderer2, ViewChild } from '@angular/core';
import { ColorsService } from '../service/colors.service';

@Component({
  selector: 'app-colors',
  templateUrl: './colors.component.html',
  styleUrls: ['./colors.component.css']
})
export class ColorsComponent implements OnInit {

  private color1: string;
  private color2: string;
  private color3: string;
  private color4: string;
  private color5: string;
  private color6: string;

  private containerBackground: string;
  private titleColor: string;

  private palette: Array<any>;

  private imageUrl: string;

  constructor(private colorService: ColorsService,
              private elementRef: ElementRef,
              private renderer: Renderer2) { }

  ngOnInit(){
  }

  ngAfterViewInit() {
    this.colorService.getImage().subscribe(data => {
      this.imageUrl = data
    });

    this.colorService.getPalette().subscribe( palette => {
      console.log(palette)
      this.palette = this.sortPalette(palette);
      this.containerBackground = this.rgbToString(this.palette[0].rgb);
      this.titleColor = this.rgbToString(this.palette[0].ttc); 
      this.color1 = this.rgbToString(this.palette[0].rgb);
      this.color2 = this.rgbToString(this.palette[1].rgb);
      this.color3 = this.rgbToString(this.palette[2].rgb);
      this.color4 = this.rgbToString(this.palette[3].rgb);
      this.color5 = this.rgbToString(this.palette[4].rgb);
      this.color6 = this.rgbToString(this.palette[5].rgb);
    })
  }

  rgbToString(rgbArray: Array<number>): string{
    return `rgb(${rgbArray[0]},${rgbArray[1]},${rgbArray[2]})`;
  }

  sortPalette(palette: any): Array<any>{
    palette.sort((a:any, b:any) => {
      if (a.population < b.population) {
        return 1
      }
      if (a.population > b.population) {
        return -1
      }
      if (a.population === b.population) {
        return 0 
      }
    })
    return palette;
  }  

}
