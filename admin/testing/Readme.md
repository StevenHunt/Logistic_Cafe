      
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
    
    
    
