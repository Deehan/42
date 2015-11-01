using UnityEngine;
using System.Collections;

public class InjectAir : MonoBehaviour {

	int cpt = 0;
	int airmax = 5;
	int air;
	bool exhaust = false;
	// Use this for initialization
	void Start () {
		air = airmax;
	}
	
	// Update is called once per frame
	void Update () {
		if (transform.localScale[1] <= 0 || transform.localScale[0] <= 0){
			Destroy(this);
			Debug.Log("You Lost!");
		}
		else if (transform.localScale[0] > 6 || transform.localScale[1] > 6){
			transform.localScale = new Vector3(0,0,0);
			Destroy(this);
			Debug.Log("You Win!\n");
		}
		if (Input.GetKey (KeyCode.Space)) {
			if (air > 0 && !exhaust){
				transform.localScale += new Vector3(0.1F, 0.1F,0.1F);
				air--;
				Debug.Log("air : " + air);
			}
			else{
				if (transform.localScale[1] > 0 || transform.localScale[0] > 0){
					transform.localScale -= new Vector3(0.1F, 0.1F,0.1F);
				}
				exhaust = true;
			}
		}
		else if (transform.localScale[1] > 0 || transform.localScale[0] > 0) {
			if (air < airmax){
				air+=2;
				Debug.Log("air : "+air);
				if (air > airmax){ exhaust = false; }
			}
			transform.localScale -= new Vector3(0.1F, 0.1F,0.1F);
		}

	}
}
