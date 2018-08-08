      Implentation of these methods/objects in a Software Design Pattern: 
      
      Commits: 
      - [Unit testing - readAll() and readName()] (https://github.com/StevenHunt/Logistic_Cafe/commit/764b90dd977f22a9aa604873b288aaca5f2a8511)
      
      - [Unit testing - readOne()] (https://github.com/StevenHunt/Logistic_Cafe/commit/99b81f31839e8a9692243ba0f5ff36d8dcd32189)
      
      - [Unit testing - update()] (https://github.com/StevenHunt/Logistic_Cafe/commit/cbf1cf8b433fe9ed8ce75d5c5cadc2e99333661f)
      
      - [Classes] (https://github.com/StevenHunt/Logistic_Cafe/commit/552ffa795a604279fc32d3f7fd76dbbecfad9804)
      
      - [readAll() & countAll()] (https://github.com/StevenHunt/Logistic_Cafe/commit/a5c930cf1e0ead8790ffcac79887cd00633d9846)
      
      - [Database Class] (https://github.com/StevenHunt/Logistic_Cafe/commit/b209c5767cfe5e7881efe2517fc47fc40ef305bd)
      
      - [Stripe OOP Payment Processing] (https://github.com/StevenHunt/Logistic_Cafe/commit/2c92644d72c61a47c5ed8cc3e3d2aefe16de7c39)
      
      - [update()] (https://github.com/StevenHunt/Logistic_Cafe/commit/32fa43815377c32bee02e0f1994d22a11c6fbad0)
      
      
      
      
      I designed these test classes to show how implementing an OOP model would help alleviate some common issues when coding
      with PHP and SQL. 
      
      * Taking an OOP approached to this project will address: 
          - Redundancy (Dont Repeat Yourself (DRY) method)
          - Modularization
          - Focus on manipulation of the data > logic
    
      Backbone of the test cases: 

      #============ DATABASE ======================
      
      Objects: 
        - Private: 
            - host - database host address
            - name - database name
            - username - database username
            - password - database password
        - Public:
            - conn - Object used to connect to the server
        
      Methods: 
        - Public:
            - getConnection() : Method used to connect to server
      
      #============ CATEGORY CLASS ================
      
      -Access: categories table
      
      Objects: 
        - Private: 
            - conn - Connection
            - table_name - Defines which table in the DB it will be accessing
        - Pubic: 
            - id - column 
            - name - column 
      
      -Methods: 
          - read(): Reads name and id based on id
          - readName(): Reads category name by id
          
      #============ PRODUCT CLASS ==================  
      
      Objects: 
        - Private: 
            - conn - Connection
            - table_name - Defines which table in the DB it will be accessing  
        - Public: 
            - id - column
            - name - column
            - price - column
            - description - column
            - catid - column
            - timestamp - column
            
     Methods: 
        - Public: 
            - create(): Creates a new product
            - readAll(): Reads all products
            - countAll(): Counts the number of products
            - readOne(): Reads one specific product
            - update(): Updates a product
    
    
    
