import React, {useEffect} from 'react'
import {render, unmountComponentAtNode} from 'react-dom'
import {usePaginatedFetch} from "./hooks";
import {Icon} from  "../components/Icon";

function Title({count}){
    return <h3>
        <Icon icon="comments"/>
        {count} Commentaire{count > 1 ? 's': ''}
    </h3>
}

function Comments (){
    const { items: comments, load, loading, count, hasMore} = usePaginatedFetch('/api/comments')

    // Chargement des commentaires dès que le composant est monté
    useEffect(() => {
        load()
    }, [])

    return <div>
        {loading && 'Chargement...'}
        {JSON.stringify(comments)}
        <Title count={count}/>
        <button onClick={load}>Charger le commentaires</button>
        {hasMore && <button disabled={loading} className="btn btn-primary" onClick={load}>Charger plus de commentaires</button>}
    </div>
}

class CommentsElement extends HTMLElement {

    connectedCallback () {
        render(<Comments/>, this)
    }

    disconnectedCallback (){
        unmountComponentAtNode(this)
    }
}

customElements.define('post-comments', CommentsElement)