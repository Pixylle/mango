import React, { useEffect, useState } from 'react';
import axios from 'axios';

const PlatCat = () => {
    const [plats, setPlats] = useState([]);
    const [isLoading, setIsLoading] = useState(true);
    const [error, setError] = useState(null);

    const categoryDiv = document.getElementById('react-plats-container');
    const categoryId = categoryDiv ? categoryDiv.getAttribute('data-category-id') : null;
    
    console.log('categoryId:', categoryId); // Проверьте, что categoryId передается
    
    useEffect(() => {
        if (!categoryId) {
            setError('Категория не найдена');
            setIsLoading(false);
            return;
        }
    
        axios.get(`/api/plats/${categoryId}`)  // Запрос на API
            .then(response => {
                console.log("Raw API response:", response);
                if (response.data && Array.isArray(response.data)) {
                    setPlats(response.data);
                } else {
                    console.error("Некорректный ответ от сервера:", response);
                    setError("Ошибка загрузки данных");
                }
                setIsLoading(false);
            })
            .catch(error => {
                console.error('Ошибка при загрузке данных:', error);
                setError('Произошла ошибка при загрузке данных');
                setIsLoading(false);
            });
    }, [categoryId]);

    if (isLoading) {
        return <div>Загрузка...</div>;
    }

    if (error) {
        return <div>{error}</div>;
    }

    return (
        <section className="menu-section">
            <div className="menu-container">
                {plats.length > 0 ? (
                    plats.map(plat => (
                        <div className="custom-card" key={plat.id}>
                            <img src={`/build/images/${plat.image}`} className="custom-card-img" alt={plat.title} />
                            <h5 className="custom-card-title">{plat.title}</h5>
                            <p className="custom-card-description">{plat.description}</p>
                            <p className="custom-card-price">{plat.prix} €</p>
                            <div className="custom-card-footer">
                            <input type="number" name="quantite" min="1" defaultValue="1" className="custom-card-quantity" id={`quantity-${plat.id}`} />

                                <input type="hidden" name="id" value={plat.id} />
                                <input type="hidden" name="title" value={plat.title} />
                                <input type="hidden" name="prix" value={plat.prix} />
                                <input type="hidden" name="id_categorie" value={plat.categorie?.id || ''} />
                                <input type="hidden" name="image" value={plat.image} />
                                <button type="button" className="custom-card-btn add-to-cart-btn" data-id={plat.id}>

                                    <i className="fa fa-shopping-cart"></i> Acheter
                                </button>
                            </div>
                        </div>
                    ))
                ) : (
                    <div>
                        <p>Désolé, il n'y a pas encore de plats dans cette catégorie.</p>
                        <img src="/build/images/faim.png" alt="Pas de plats" className="message-image" />
                    </div>
                )}
            </div>
        </section>
    );
};

export default PlatCat;
