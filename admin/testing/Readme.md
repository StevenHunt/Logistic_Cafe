**Implentation of these methods/objects in a Software Design Pattern:**
      
**Commits:**

1. [Unit testing - readAll() and readName()](https://github.com/StevenHunt/Logistic_Cafe/commit/764b90dd977f22a9aa604873b288aaca5f2a8511)
      
2. [Unit testing - readOne()](https://github.com/StevenHunt/Logistic_Cafe/commit/99b81f31839e8a9692243ba0f5ff36d8dcd32189)
      
3. [Unit testing - update()](https://github.com/StevenHunt/Logistic_Cafe/commit/cbf1cf8b433fe9ed8ce75d5c5cadc2e99333661f)
      
4. [Classes: products.php, category.php](https://github.com/StevenHunt/Logistic_Cafe/commit/552ffa795a604279fc32d3f7fd76dbbecfad9804)
      
5. [readAll() & countAll(): index.php](https://github.com/StevenHunt/Logistic_Cafe/commit/a5c930cf1e0ead8790ffcac79887cd00633d9846)
      
6. [Database Class: database.php](https://github.com/StevenHunt/Logistic_Cafe/commit/b209c5767cfe5e7881efe2517fc47fc40ef305bd)
      
7. [Stripe OOP Payment Processing](https://github.com/StevenHunt/Logistic_Cafe/commit/2c92644d72c61a47c5ed8cc3e3d2aefe16de7c39)
      
8. [update(): update_product.php](https://github.com/StevenHunt/Logistic_Cafe/commit/32fa43815377c32bee02e0f1994d22a11c6fbad0)

---

**Site Credentials**
1. [AWS EC2](http://ec2-34-216-179-83.us-west-2.compute.amazonaws.com/)

2. [AWS RDS - phpMyadmin](http://ec2-34-216-179-83.us-west-2.compute.amazonaws.com/phpmyadmin)
  * Username: root438
  * Password: foobar438
  * Server: Database Server
  
3. Customer Login: Please register your own account or use test account: 
  * Username: test@csumb.edu
  * Password: foobar
  
4. Admin Login (Link to *Admin - Dashboard* on Login Page): 
  * Username: test@csumb.edu
  * Password: foobar

---
     
I designed these test classes to show how implementing an OOP model would help alleviate some common issues when coding
with PHP and SQL. 
      
**Taking an OOP approached to this project will address:** 
  1. Redundancy (Dont Repeat Yourself (DRY) method)
  2. Modularization
  3. Focus on manipulation of the data > logic
  
  ---
    
**Backbone of the test cases:** 

**============ DATABASE ======================**
      
**Objects:** 
  * *Private:*
  1. host: database host address
  2. name: database name
  3. username: database username
  4. password: database password
  * *Public:*
  1. conn: Object used to connect to the server
        
**Methods:** 
  * *Public:*
  1. getConnection() : Method used to connect to server
      
**============ CATEGORY CLASS ================**
      
*Access: categories table
      
**Objects:**
  * *Private:*
  1. conn - Connection
  2. table_name - Defines which table in the DB it will be accessing
  * *Pubic:* 
  1. id - column 
  2. name - column 
      
**Methods:** 
  1. read(): Reads name and id based on id
  2. readName(): Reads category name by id

**============ PRODUCT CLASS ==================**  
      
**Objects:** 
  * *Private:* 
  1. conn - Connection
  2. table_name - Defines which table in the DB it will be accessing  
  * *Public:* 
  1. id - column
  2. name - column
  3. price - column
  4. description - column
  5. catid - column
  6. timestamp - column
            
**Methods:** 
  * *Public:* 
  1. create(): Creates a new product
  2. readAll(): Reads all products
  3. countAll(): Counts the number of products
  4. readOne(): Reads one specific product
  5. update(): Updates a product
    
    
    
