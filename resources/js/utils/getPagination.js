export default function(obj, pagesToShow = 10) {
    return {
        current: obj.current_page,
        on_last_page: obj.current_page === obj.last_page,
        on_first_page: obj.current_page === 1,
        from: obj.from,
        total: obj.total,
        to: obj.to,
        last_page: obj.last_page,
        next_page: obj.next_page_url ? obj.current_page + 1 : null,
        previous_page: obj.prev_page_url ? obj.current_page - 1 : null,
        per_page: obj.per_page,
        // pages: makePageLinks(obj.current, obj.to, pagesToShow),
        // TODO: do we want to generate those extra links here? maybe? I don't know
    };
    // return {
    //     "current_page": 1,
    //     "first_page_url": "http://bc-kb.test/api/projects?page=1",
    //     "from": 1,
    //     "last_page": 4,
    //     "last_page_url": "http://bc-kb.test/api/projects?page=4",
    //     "next_page_url": "http://bc-kb.test/api/projects?page=2",
    //     "path": "http://bc-kb.test/api/projects",
    //     "per_page": 50,
    //     "prev_page_url": null,
    //     "to": 50,
    //     "total": 162
    // };
}
