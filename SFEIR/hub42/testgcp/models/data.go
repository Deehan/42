package models

import (
	"time"
)

type Data struct {
	Date   time.Time
	Json   string
	Hidden bool
	Type   string
	Cap    string
	Price  string
}

type Object struct {
	Index int64
	Title string
	Model string
	Type  string
	Desc  string
	Cap   int
	Price int
	Own   string
}
// Generic structure fetched from Google Sheet API
type S_feed struct{
	Label 	string
	Values	[]string
}

type Sheet struct {
	Sheet 	string
	Key 	string
}