package controllers

import (
	"github.com/gorilla/mux"

	"appengine"

	"encoding/json"
	"io/ioutil"
	"net/http"
	"net/url"
	"strconv"
	"strings"
	"time"

	"models"
	"service"
"appengine/datastore"
	// "io"
)

var object models.Object

// Function ReqObject -> Gere toutes les requetes liées aux objects (Voiture, Imprimante 3D, Cours)
func GetAllObject(w http.ResponseWriter, req *http.Request) {
	c := appengine.NewContext(req)
	var obj []models.Object
	var tmp models.Object

	tab := make(map[string]string)
	m, _ := url.ParseQuery(req.URL.RawQuery)
	for index, element := range m {
		if element[0] != "" {
			tab[strings.Title(index)+" ="] = req.URL.Query().Get(index)
		}
	}
	lilist, kikeys, _ := service.GetData(c, tab)
	if lilist != nil {
		for i, v := range lilist {
			if lilist[i].Hidden == false {
				json.Unmarshal([]byte(v.Json), &tmp)
				tmp.Index = kikeys[i].IntID()
				obj = append(obj, tmp)
			}
		}
		w.Header().Set("content-type", "application/json")
		json.NewEncoder(w).Encode(obj)
	}
}

func GetObject(w http.ResponseWriter, req *http.Request) {
	vars := mux.Vars(req) // récupère les valeurs d'url
	// vars["id"] contient l'id utilisateur...
	c := appengine.NewContext(req)
	var obj []models.Object
	var tmp models.Object

	id, _ := strconv.ParseInt(vars["id"], 10, 64)
	lilist, kikeys, _ := service.GetDataById(c, id)
	if lilist != nil {
		for i, v := range lilist {
			if lilist[i].Hidden == false {
				json.Unmarshal([]byte(v.Json), &tmp)
				tmp.Index = kikeys[i].IntID()
				obj = append(obj, tmp)
			}
		}
		w.Header().Set("content-type", "application/json")
		json.NewEncoder(w).Encode(obj)
	}
}

func AddObject(w http.ResponseWriter, req *http.Request) {
	c := appengine.NewContext(req)

	body, _ := ioutil.ReadAll(req.Body)
	json.Unmarshal(body, &object)
	d := models.Data{
		Date:  time.Now(),
		Json:  string(body),
		Type:  object.Type,
		Cap:   strconv.Itoa(object.Cap),
		Price: strconv.Itoa(object.Price),
	}
	service.AddData(d, c)
}

func ModifyObject(w http.ResponseWriter, req *http.Request) {
	c := appengine.NewContext(req)
	vars := mux.Vars(req)

	body, _ := ioutil.ReadAll(req.Body)
	json.Unmarshal(body, &object)
	d := models.Data{
		Date:  time.Now(),
		Json:  string(body),
		Type:  object.Type,
		Cap:   strconv.Itoa(object.Cap),
		Price: strconv.Itoa(object.Price),
	}
	object.Index, _ = strconv.ParseInt(vars["id"], 10, 64)
	service.PutData(d, c, object.Index)
}

func DeleteObject(w http.ResponseWriter, req *http.Request) {
	vars := mux.Vars(req)
	c := appengine.NewContext(req)

	id, _ := strconv.ParseInt(vars["id"], 10, 64)
	lilist, _, _ := service.GetDataById(c, id)
	lilist[0].Hidden = true
	service.PutData(lilist[0], c, id)
}

func GetSheet(w http.ResponseWriter, r *http.Request){
	// m, _ := url.ParseQuery(r.URL.RawQuery)
	c := appengine.NewContext(r)
	key := datastore.NewIncompleteKey(c, "sheet", nil)
	d:=models.Sheet{
		Sheet : "car_sheet",
		Key : "1y_FG0sWMHIiZvx3cqUTpveuK9ve5TUL27_WqETB7Awo",
	}
	datastore.Put(c, key, &d)
	// io.WriteString(w, GetSheetDatastore(m, c))
}
