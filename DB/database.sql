-- first you need to create DB "ecom":


-- now create all this tables:

CREATE TABLE client (
    ClientId INT(11) PRIMARY KEY AUTO_INCREMENT,
    ClientName VARCHAR(255),
    Address VARCHAR(255),
    Phone VARCHAR(20),
    Password VARCHAR(255),
    Email VARCHAR(255)
);

CREATE TABLE admin (
    AdminId INT(11) PRIMARY KEY AUTO_INCREMENT,
    AdminName VARCHAR(255),
    Username VARCHAR(255),
    Password VARCHAR(255),
    Email VARCHAR(255)
);

CREATE TABLE categorie (
    CategorieId INT(11) PRIMARY KEY AUTO_INCREMENT,
    CategorieName VARCHAR(255),
    Description TEXT
);

CREATE TABLE product (
    ProductId INT(11) PRIMARY KEY AUTO_INCREMENT,
    Name VARCHAR(255),
    Description TEXT,
    Photo TEXT,
    Price FLOAT,
    Stock INT(11),
    CategorieId INT(11),
    WishlistId INT(11),
    FOREIGN KEY (CategorieId) REFERENCES categorie(CategorieId),
    FOREIGN KEY (WishlistId) REFERENCES wishlist(WishlistId)
);

CREATE TABLE wishlist (
    WishlistId INT(11) PRIMARY KEY AUTO_INCREMENT,
    ClientId INT(11),
    ProductId INT(11),
    FOREIGN KEY (ClientId) REFERENCES client(ClientId),
    FOREIGN KEY (ProductId) REFERENCES product(ProductId)
);
CREATE TABLE wishlist_product (
    WishlistProductId INT(11) PRIMARY KEY AUTO_INCREMENT,
    WishlistId INT(11),
    ProductId INT(11),
    FOREIGN KEY (WishlistId) REFERENCES wishlist(WishlistId) ON DELETE CASCADE,
    FOREIGN KEY (ProductId) REFERENCES product(ProductId) ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE orders (
    OrderId INT(11) PRIMARY KEY AUTO_INCREMENT,
    OrderDate DATE,
    ClientName VARCHAR(255),
    Status VARCHAR(50),
    TrackingNb VARCHAR(255),
    ClientId INT(11),
    ShippingInfoId INT(11),
    FOREIGN KEY (ClientId) REFERENCES client(ClientId),
    FOREIGN KEY (ShippingInfoId) REFERENCES shippinginfo(ShippingInfoId)
);

CREATE TABLE order_items (
    OrderItemId INT(11) PRIMARY KEY AUTO_INCREMENT,
    OrderId INT(11),
    ProductId INT(11),
    Quantity INT(11),
    Price FLOAT,
    FOREIGN KEY (OrderId) REFERENCES orders(OrderId),
    FOREIGN KEY (ProductId) REFERENCES product(ProductId)
);

CREATE TABLE shippinginfo (
    ShippingInfoId INT(11) PRIMARY KEY AUTO_INCREMENT,
    TrackingNb VARCHAR(255),
    ShippingCost FLOAT,
    Address VARCHAR(255),
    Postcode INT(11),
    ProviderId INT(11),
    FOREIGN KEY (ProviderId) REFERENCES shippingprovider(ProviderId)
);

CREATE TABLE shippingprovider (
    ProviderId INT(11) PRIMARY KEY AUTO_INCREMENT,
    ProviderName VARCHAR(255),
    ContactInfo VARCHAR(255)
);
