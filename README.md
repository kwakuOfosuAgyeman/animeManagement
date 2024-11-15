
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
    
    # Jikan API Configuration 
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
    
    `php artisan fetch:anime-list` 
    
-   This command fetches the top 100 anime while adhering to API rate limits.

----------

### **2. Accessing the API**

Once data is fetched, you can access it via the built-in API.

-   Example Endpoint:
    
    `GET /api/anime/{slug}` 
    
    Replace `{slug}` with the unique identifier of an anime.
    
-   Example Response:
 
    
    `{
        "sucess": true,
        "data": {
            "mal_id": 52991,
            "title": "Sousou no Frieren",
            "title_english": "Frieren: Beyond Journey's End",
            "title_japanese": "葬送のフリーレン",
            "synopsis": "During their decade-long quest to defeat the Demon King, the members of the hero's party—Himmel himself, the priest Heiter, the dwarf warrior Eisen, and the elven mage Frieren—forge bonds through adventures and battles, creating unforgettable precious memories for most of them.\n\nHowever, the time that Frieren spends with her comrades is equivalent to merely a fraction of her life, which has lasted over a thousand years. When the party disbands after their victory, Frieren casually returns to her \"usual\" routine of collecting spells across the continent. Due to her different sense of time, she seemingly holds no strong feelings toward the experiences she went through.\n\nAs the years pass, Frieren gradually realizes how her days in the hero's party truly impacted her. Witnessing the deaths of two of her former companions, Frieren begins to regret having taken their presence for granted; she vows to better understand humans and create real personal connections. Although the story of that once memorable journey has long ended, a new tale is about to begin.\n\n[Written by MAL Rewrite]",
            "background": "Sousou no Frieren was released on Blu-ray and DVD in seven volumes from January 24, 2024, to July 17, 2024.",
            "episodes": 28,
            "rating": "PG-13 - Teens 13 or older",
            "score": 9.32,
            "scored_by": 541059,
            "rank": 1,
            "popularity": 185,
            "members": 945959,
            "favorites": 56484,
            "image_url": "https://cdn.myanimelist.net/images/anime/1015/138006.jpg",
            "type": "TV",
            "source": "Manga",
            "season": "fall",
            "year": 2023,
            "genres": [
                {
                    "id": 2,
                    "name": "Adventure"
                },
                {
                    "id": 8,
                    "name": "Drama"
                },
                {
                    "id": 10,
                    "name": "Fantasy"
                }
            ],
            "studios": [
                {
                    "id": 11,
                    "name": "Madhouse"
                }
            ]
        }
    }` 
    

### **Rate Limiting Configuration**

Rate limiting for API calls is handled in the `ApiService` class.


----------

## Contributing

Feel free to contribute by submitting issues or pull requests. For major changes, please open an issue first to discuss your ideas.

----------

## License

This project is licensed under the MIT License.

----------

With this `README.md`, users will have clear instructions for installing, configuring, and using your system effectively.
