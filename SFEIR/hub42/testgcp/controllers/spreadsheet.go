package controllers

import (
"net/url"
"fmt"
"appengine"
"appengine/urlfetch"
"appengine/datastore"
"encoding/json"
// "encoding/xml"
"io/ioutil"
"strings"
"launchpad.net/xmlpath"
"net/http"
"log"
// "io"
// "os"
)
// Generic structure fetched from Google Sheet API
type s_feed struct{
	Label 	string
	Values	[]string
}

type sheet struct {
	Sheet 	string
	Key 	string
}

func displayStruct(w http.ResponseWriter, structure s_feed){
	fmt.Fprintf(w, "%s\n", structure.Label)
	for _,element:=range structure.Values{
		fmt.Fprintf(w, " * %s\n", element)
	}
}

func GetSheetDatastore(m map[string][]string, c appengine.Context) (link string) {
   var q *(datastore.Query)
   var valueget    []sheet
   q = datastore.NewQuery("sheet")
   for index,element := range m {
       /*if element[0] != "" {
           q = q.Filter(strings.Title(index) + " =", element[0])
       }
       break*/
       if index == "Sheet" || index == "sheet"{
       		q = q.Filter(strings.Title(index) + " =", element[0])
       }
   }
   if _, err := q.GetAll(c, &valueget); err != nil {
       return err.Error()
   }
   if len(valueget) == 0 {
       return "not found"
   }
   return (valueget[0].Key)
}

func getSheetID(sheetID, tabID string) string{
	return ("https://spreadsheets.google.com/feeds/list/"+sheetID+"/"+tabID+"/public/full")
}
func getTabList(r *http.Request, sheetID string) map[string]string{
	sheet := "https://spreadsheets.google.com/feeds/worksheets/"+sheetID+"/public/full"
	log.Printf("worksheetlist=%s\n", sheet)
	c := appengine.NewContext(r)
	client := urlfetch.Client(c)
	resp, _ := client.Get(sheet)
	data, _ := ioutil.ReadAll(resp.Body)
	nom := xmlpath.MustCompile("//entry/title")
	root, _ := xmlpath.Parse(strings.NewReader(string(data)))
	value := nom.Iter(root)
	var names []string
	for value.Next(){
		names = append(names, value.Node().String())
	}
	id := xmlpath.MustCompile("//entry/id")
	value2 := id.Iter(root)
	var ids []string
	couple := make(map[string]string)
	for value2.Next() == true{
		res :=  strings.Split(value2.Node().String(), "/")
		ids = append(ids, res[len(res) - 1])
	}
	for i:=0; i<len(names); i++{
		couple[names[i]]=ids[i]
	}
	for name, id := range couple{
		log.Printf("%s - %s\n", name, id)
	}
	return couple
}
func getSheetX(r *http.Request, sheetAddr string) []byte {
	c := appengine.NewContext(r)
	client := urlfetch.Client(c)
	resp, _ := client.Get(sheetAddr)
	// if err != nil {
	// 	http.Error(w, err.Error(), http.StatusInternalServerError)
	// }
	data, _ := ioutil.ReadAll(resp.Body)
	return data
}
func getSheetS(r *http.Request, sheetAddr string) s_feed {
	data := getSheetX(r, sheetAddr)
	e := s_feed{}
	path := xmlpath.MustCompile("//title")
	root, _ := xmlpath.Parse(strings.NewReader(string(data)))
	value := path.Iter(root)
	begin := true
	for value.Next() == true {
		if begin{
			e.Label=value.Node().String()
		}else{
			e.Values=append(e.Values, value.Node().String())
		}
		begin=false
	}
	return e
}
func getSheetJ(r *http.Request, sheetAddr string) []byte {
	e := getSheetS(r, sheetAddr)
	jobj, _ := json.Marshal(e)
	return jobj
}

func printOnglets(w http.ResponseWriter, r *http.Request, sheetID string){
	fmt.Fprintf(w, "please select a tab: &onglet=<onglet>\n")
	for name,_:=range getTabList(r, sheetID){
		fmt.Fprintf(w, " - %s\n", name)
	}
}

func PrintSheet(w http.ResponseWriter, r *http.Request) {
	m, _ := url.ParseQuery(r.URL.RawQuery)
	c := appengine.NewContext(r)
	sheetID:=GetSheetDatastore(m, c)
	// format:=0
	// onglet:=false
	for index,element := range m{
		if index=="Onglet" || index=="onglet"{
			tablist:=getTabList(r, sheetID)
			for name,id:=range tablist{
				if element[0]==name{
					/*if format==0{
						fmt.Fprintf(w, "%s", getSheetX(r, getSheetID(sheetID, id)))
					}else if format==1{
						displayStruct(w, getSheetS(r, getSheetID(sheetID, id)))
					}else if format==2{
						fmt.Fprintf(w, "%s", string(getSheetJ(r, getSheetID(sheetID, id))))
					}*/
					// fmt.Fprintf(w, "%s", string(getSheetJ(r, getSheetID(sheetID, id))))
					// log.Printf("%s", string(getSheetJ(r, getSheetID(sheetID, id))))
					w.Header().Set("content-type", "application/json")
					json.NewEncoder(w).Encode(getSheetS(r, getSheetID(sheetID, id)))
					// io.WriteString(w, string(getSheetJ(r, getSheetID(sheetID, id))))
					break
				}
			}
		//	onglet=true
		} /*else if index=="Format" || index=="format"{
			if element[0]=="xml"{
				format = 0
				// fmt.Fprintf(w, "%s", getSheetX(r, sheetID))
			}else if element[0]=="structure"{
				format = 1
				// displayStruct(w, getSheetS(r, sheetID))
			}else if element[0]=="json"{
				format = 2
				// fmt.Fprintf(w, "%s", string(getSheetJ(r, sheetID)))
			}
		}*/
	}
	/*if onglet==false{
		printOnglets(w, r, sheetID)
	}*/
}
