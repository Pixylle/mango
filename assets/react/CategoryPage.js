import React, { useState, useEffect } from 'react';

const CategoryPage = ({ categoryId }) => {
    const [plats, setPlats] = useState([]); // Список блюд
    const [isLoading, setIsLoading] = useState(true); // Состояние загрузки
    const [error, setError] = useState(null); // Обработка ошибок

    useEffect(() => {
        // Делаем запрос на сервер, чтобы получить блюда категории
        fetch(`/api/categorie/${categoryId}/plats`) // Убедитесь, что API-роут правильный
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Ошибка при загрузке данных');
                }
                return response.json();
            })
            .then((data) => {
                setPlats(data); // Устанавливаем список блюд
                setIsLoading(false); // Загрузка завершена
            })
            .catch((err) => {
                setError(err.message);
                setIsLoading(false);
            });
    }, [categoryId]);

    if (isLoading) {
        return <p>Загрузка блюд...</p>; // Показываем индикатор загрузки
    }

    if (error) {
        return <p>Ошибка: {error}</p>; // Показываем сообщение об ошибке
    }

    if (plats.length === 0) {
        return <p>Блюда в этой категории не найдены.</p>; // Сообщение, если блюд нет
    }

    return (
        <section className="menu-section">
            <div className="menu-container">
                {plats.map((plat) => (
                    <div className="custom-card" key={plat.id}>
                        <form method="POST" action="addcard.php" className="custom-card">
                            <img
                                src={`/src/img/${plat.image}`}
                                alt={plat.libelle}
                                className="custom-card-img"
                            />
                            <h5 className="custom-card-title">{plat.libelle}</h5>
                            <p className="custom-card-description">{plat.description}</p>
                            <p className="custom-card-price">{`${plat.prix} €`}</p>
                            <div className="custom-card-footer">
                                <input
                                    type="number"
                                    name="quantite"
                                    min="1"
                                    defaultValue="1"
                                    className="custom-card-quantity"
                                />
                                <input type="hidden" name="id" value={plat.id} />
                                <input type="hidden" name="libelle" value={plat.libelle} />
                                <input type="hidden" name="prix" value={plat.prix} />
                                <input type="hidden" name="categorie_id" value={plat.categorie_id} />
                                <input type="hidden" name="image" value={plat.image} />
                                <button
                                    type="submit"
                                    name="action"
                                    value="buy_now"
                                    className="custom-card-btn"
                                >
                                    <i className="fa fa-shopping-cart"></i> Купить
                                </button>
                            </div>
                        </form>
                    </div>
                ))}
            </div>
        </section>
    );
};

export default CategoryPage;
