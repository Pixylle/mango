import React, { useEffect, useState } from 'react';

const CategoriesApp = () => {
    const [categories, setCategories] = useState([]);

    useEffect(() => {
        if (window.categoriesData) {
            setCategories(window.categoriesData);
        }
    }, []);

    return (
        <section id="section1" data-speed="8" data-type="background" className="Catégorie parallax p-2">
            <div>
                <div className="row justify-content-center mb-4 title">
                    <div className="col-12 d-flex align-items-center justify-content-center">
                        <span className="decorative-element me-2"></span>
                        <h3 className="category-title">Catégories</h3>
                        <span className="decorative-element ms-2"></span>
                    </div>
                </div>
                <div className="container justify-content-center mb-3">
                    {categories.length > 0 ? (
                        categories.map((categorie) => (
                            <div key={categorie.id} className="col-3 cath">
                                <a href={`/platcat/${categorie.id}`}>
                                    <p className="category-name">{categorie.libelle}</p>
                                    <img
                                        src={`/build/images/${categorie.image}`}
                                        alt={categorie.libelle}
                                        className="category-image"
                                    />
                                </a>
                            </div>
                        ))
                    ) : (
                        <p>Категории не найдены</p>
                    )}
                </div>
            </div>
        </section>
    );
};

export default CategoriesApp;
