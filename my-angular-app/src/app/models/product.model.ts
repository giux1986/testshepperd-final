export interface Product {
  id: number;
  name: string;
  price: number;
  description: string;
  [key: string]: string | number; // Index signature for dynamic properties

}