# CREATIVESTYLE APP

Creativestyle recruitment task.

This is a simple e-commerce cart system that includes two types of discount policies:
1. **Discount for every fifth product of the same type**: Every fifth product of the same type in the cart is free.
2. **Percentage discount on the total cart value**: A 10% discount is applied to the total cart value if it exceeds 100.
3. **Promotion rules**: If both discount conditions are met, only the promotion with the higher discount is applied.

## Features
- **Add products to cart**: Users can add multiple products to the cart with specified quantities.
- **View cart**: Users can view the cart, including the total price, quantity of items, and the applicable discount.
- **Apply discounts**: The system automatically applies the best discount based on the cart contents and the discount rules.
- **Clear cart**: Users can clear the cart and start over.

## Discount Policies

### 1. Discount for every fifth product of the same type
- For every five items of the same product in the cart, one is free.
- For example, if a user adds 5 units of Product A, they will only pay for 4 units.

### 2. 10% Discount on total cart value
- A 10% discount is applied if the total value of the cart exceeds 100.
- This discount is calculated on the total value of the cart before applying the "every fifth product free" discount.

### 3. Promotion rules
- If both discount conditions are met (total value exceeds 100 and there are multiples of 5 items of the same product), the system will apply the discount that offers the greater savings.
- Promotions cannot be combined.

## Example Scenarios

### Scenario 1: 4 units of Product A (20 each) and 2 units of Product B (35 each)
- **Total for Product A**: 4 x 20 = 80
- **Total for Product B**: 2 x 35 = 70
- **Total cart value**: 80 + 70 = 150
- **Applicable discount**: 10% discount (because total exceeds 100)
- **Final price**: 150 - 15 = **135**

### Scenario 2: 5 units of Product A (20 each) and 2 units of Product B (35 each)
- **Total for Product A**: 5 x 20 = 100
- **Total for Product B**: 2 x 35 = 70
- **Total cart value**: 100 + 70 = 170
- **Applicable discount**: Free product for the fifth unit of Product A (20)
- **Final price**: 170 - 20 = **150**

### Scenario 3: 10 units of Product A (20 each) and 3 units of Product B (35 each)
- **Total for Product A**: 10 x 20 = 200
- **Total for Product B**: 3 x 35 = 105
- **Total cart value**: 200 + 105 = 305
- **Applicable discount**: Free products for two sets of five units of Product A (2 x 20 = 40)
- **Final price**: 305 - 40 = **265**

### Scenario 4: 2 units of Product A (20 each) and 1 unit of Product B (35)
- **Total for Product A**: 2 x 20 = 40
- **Total for Product B**: 1 x 35 = 35
- **Total cart value**: 40 + 35 = 75
- **Applicable discount**: None (cart value below 100 and no fifth product)
- **Final price**: **75**

## Run

The whole project is contenerized using docker containers, so to run Creativestyle project you need to use make command:

```bash  
 make run  
```  
this command will start project in docker containers. The project will be available on localhost:8081

```bash  
 make down  
```  
this command will stop project and remove all docker containers

## Test
To test project, simply run:
```bash  
 make test  
```  
This command performs all tests withing project, and also runs static code analysis to prevent any bugs.

## Available Endpoints

| HTTP Method | Endpoint         | Description                                 | Request Parameters     |
|-------------|------------------|---------------------------------------------|------------------------|
| GET         | `/products`       | Returns a list of all available products.   | N/A                    |
| GET         | `/cart`           | Displays the current contents of the cart and the final price with applicable discounts. | N/A                    |
| POST        | `/cart/add/{id}`  | Adds a product to the cart with a specified quantity. | `quantity` (optional, default: 1) |
| GET         | `/cart/clear`     | Clears the cart, removing all items.        | N/A                    |

### Detailed Description of Endpoints:

- **GET `/products`**: Fetches and displays a list of all available products. This can be used to browse products and select items to add to the cart.
  
- **GET `/cart`**: Displays the current cart with all added items, including the total quantity and the final price after discounts. The discounts include:
  - 10% discount on total price if the cart exceeds 100.
  - Free product for every fifth unit of the same product.
  
- **POST `/cart/add/{id}`**: Adds a product to the cart. You can specify the `quantity` in the request body (default is 1). The product is identified by its `{id}` parameter, which is passed in the URL.

- **GET `/cart/clear`**: Clears all items from the cart and resets it. After this action, the cart will be empty.

## Authors

- [@krzysztof heigel](https://github.com/kfheigel)
