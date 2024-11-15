
# Anime Data Management System

This project is a Laravel-based system that integrates with the Jikan API to fetch and manage anime data. It provides the following main functionalities:

1.  Fetch and store anime data from the Jikan API, including handling pagination and rate limiting.
2.  Retrieve and display sanitized anime data from the database through an API.

----------

## Features

-   **Fetch Anime Data**: Automatically fetches and updates the top anime data from the Jikan API.
-   **Rate Limiting**: Adheres to Jikan's API limits (3 requests per second, 60 requests per minute).
-   **Data Sanitization**: Ensures all fetched data is clean before saving it to the database.
-   **Database Operations**: Uses `updateOrCreate` to handle upserts efficiently.
-   **API Endpoint**: Provides a structured API for querying the stored anime data.

----------

## Prerequisites

Before installing, ensure you have the following installed:

-   **PHP** (>=8.1)
-   **Composer**
-   **Laravel Framework** (v11)
-   **MySQL** or another database supported by Laravel
-   **Git** 

----------

## Installation

Follow these steps to set up the system:

1.  **Clone the Repository**:
    
    `git clone <repository-url>
    cd <repository-folder>` 
    
2.  **Install Dependencies**:
    
    `composer install` 
    
3.  **Set Up Environment Variables**: Copy the example environment file and configure your settings.
    
    `cp .env.example .env` 
    
    Update `.env` with your database credentials and other configurations:
    
    `DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=anime_db
    DB_USERNAME=root
    DB_PASSWORD=yourpassword
    
    # Jikan API Configuration (if applicable)
    API_URL=https://api.jikan.moe/v4` 
    
4.  **Generate Application Key**:
    
    `php artisan key:generate` 
    
5.  **Run Migrations**:
    
    `php artisan migrate` 
    
6.  **Run the Application**:
    
    `php artisan serve` 
    

----------

## Usage

### **1. Fetching Anime Data**

To fetch and store anime data from the Jikan API:

-   Run the following artisan command:
    
    `php artisan anime:fetch-top` 
    
-   This command fetches the top 100 anime while adhering to API rate limits.

----------

### **2. Accessing the API**

Once data is fetched, you can access it via the built-in API.

-   Example Endpoint:
    
    `GET /api/anime/{slug}` 
    
    Replace `{slug}` with the unique identifier of an anime.
    
-   Example Response:
 
    
    `{
        "mal_id": 1,
        "title": "Cowboy Bebop",
        "synopsis": "In the year 2071...",
        "image_url": "https://cdn.myanimelist.net/...",
        "episodes": 26
    }` 
    

### **Rate Limiting Configuration**

Rate limiting for API calls is handled in the `ApiService` class. Configuration is done using the `API_RATE_LIMIT` environment variable.

----------

## Testing

To ensure your system works as expected:

1.  **Run Unit Tests**:
    
    `php artisan test` 
    
2.  **Verify API Responses**: Use tools like Postman or Curl to interact with the API and ensure it returns expected results.

----------

## Contributing

Feel free to contribute by submitting issues or pull requests. For major changes, please open an issue first to discuss your ideas.

----------

## License

This project is licensed under the MIT License.

----------

With this `README.md`, users will have clear instructions for installing, configuring, and using your system effectively.
