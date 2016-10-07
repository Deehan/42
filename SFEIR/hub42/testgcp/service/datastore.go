package service

import (
	"appengine"
	"appengine/datastore"

	"models"
)

func AddData(d models.Data, c appengine.Context) string {
	key := datastore.NewIncompleteKey(c, "object", nil)
	a, _ := datastore.Put(c, key, &d)
	return (a.String())
}

func PutData(d models.Data, c appengine.Context, id int64) string {
	key := datastore.NewKey(c, "object", "", id, nil)
	a, _ := datastore.Put(c, key, &d)
	return (a.String())
}

func GetData(c appengine.Context, tab map[string]string) ([]models.Data, []*datastore.Key, error) {
	var listKeys []models.Data
	var q *(datastore.Query)

	q = datastore.NewQuery("object")
	for index, element := range tab {
		q = q.Filter(index, element)
	}
	if keys, err := q.GetAll(c, &listKeys); err != nil {
		return nil, nil, err
	} else {
		return listKeys, keys, nil
	}
}

func GetDataById(c appengine.Context, id int64) ([]models.Data, []*datastore.Key, error) {
	var listKeys []models.Data
	var q *(datastore.Query)

	key := datastore.NewKey(c, "object", "", id, nil)
	q = datastore.NewQuery("object").Filter("__key__ =", key)

	if keys, err := q.GetAll(c, &listKeys); err != nil {
		return nil, nil, err
	} else {
		return listKeys, keys, nil
	}
}
