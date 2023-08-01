import { Component, OnInit } from '@angular/core';
import { CommonModule } from '@angular/common'; // Import CommonModule
import { ProductService } from '../services/product.service';
import { Product } from '../models/product.model';

@Component({
  selector: 'app-product-list',
  templateUrl: './product-list.component.html',
  styleUrls: ['./product-list.component.css'],
})
export class ProductListComponent implements OnInit {
  products: Product[] = [];
  filterText: string = '';
  sortedProducts: Product[] = [];
  sortKey: string = 'name'; // Default sort key (name or price)
  sortDirection: string = 'asc'; // Default sort direction (asc or desc)


  constructor(private productService: ProductService) {}

  ngOnInit(): void {
    this.getProducts();
     

    addEventListener('keydown', (event: KeyboardEvent) => {
      if (event.key === 'Delete' || event.key === 'Backspace') {
        this.applyFilter()
      }
    });
  }
  getProducts(): void {
    this.productService.getAllProducts().subscribe(
      (products: any) => {
        this.products = products["data"];
        this.sortProducts();
      },
      (error) => {
        console.error('Error fetching products:', error);
      }
    );
  }
  // Function to sort the products based on the current sortKey and sortDirection
  sortProducts(): void {
	  this.sortedProducts = [...this.products]; // Copy the products array to maintain the original data

	  this.sortedProducts.sort((a: Product, b: Product) => {
	    const aValue = a[this.sortKey] as string | number;
	    const bValue = b[this.sortKey] as string | number;

	    if (this.sortKey === 'price') {
	      // For 'price', compare as numbers
	      if (this.sortDirection === 'asc') {
	        return Number(aValue) - Number(bValue);
	      } else {
	        return Number(bValue) - Number(aValue);
	      }
	    } else {
	      // For other keys (e.g., 'name'), compare as strings
	      if (this.sortDirection === 'asc') {
	        return String(aValue).localeCompare(String(bValue), 'en', { sensitivity: 'base' });
	      } else {
	        return String(bValue).localeCompare(String(aValue), 'en', { sensitivity: 'base' });
	      }
	    }
	  });
	}

  // Function to toggle the sort direction (asc or desc)
  toggleSortDirection(): void {
    this.sortDirection = this.sortDirection === 'asc' ? 'desc' : 'asc';
    this.sortProducts();
  }

  // Function to change the sort key (name or price)
  changeSortKey(key: string): void {
    this.sortKey = key;
    this.sortProducts();
  }

  applyFilter(): void {
  	this.getProducts();
    this.products = this.products.filter((product) =>
      product.name.toLowerCase().includes(this.filterText.toLowerCase())
    );
    console.log(this.products.length)
  }

  resetFilter(): void {
     this.getProducts();
  }
}
