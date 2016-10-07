package router

import (
	"controllers"
	"github.com/gorilla/mux"
	"net/http"
)

func init() {
	r := mux.NewRouter().PathPrefix("/api/").Subrouter()
	r.HandleFunc("/objects", controllers.GetAllObject).Methods("GET")
	r.HandleFunc("/objects/{id:[0-9]*}", controllers.GetObject).Methods("GET")
	r.HandleFunc("/objects", controllers.AddObject).Methods("POST")
	r.HandleFunc("/objects/{id:[0-9]*}", controllers.ModifyObject).Methods("PUT")
	r.HandleFunc("/objects/{id:[0-9]*}", controllers.DeleteObject).Methods("DELETE")
	r.HandleFunc("/api/sheets", controllers.GetSheet)
	// http://localhost:8080/api/info?sheet=car_sheet&format=json
	r.HandleFunc("/info", controllers.PrintSheet)
	r.HandleFunc("/add", controllers.GetSheet)
	http.Handle("/api/", r)
}
